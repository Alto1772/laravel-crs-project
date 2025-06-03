import joblib
import numpy as np

import pandas as pd
from sklearn.model_selection import train_test_split, GridSearchCV
from sklearn.metrics import accuracy_score, classification_report, confusion_matrix
from typing import Dict, List, Tuple, Any
from sqlalchemy.orm import Session

from .models import TRAINING_REPORT_PATH, DataProcessor, KNNRecommender
from .database import BoardProgram, Questionnaire, AnswerRow, Answer, Choice, Question
from .models import MODEL_PATH, FEATURE_NAMES_PATH, BOARD_PROGRAMS_PATH


def get_training_data(session: Session) -> Tuple[pd.DataFrame, pd.DataFrame]:
    """
    Retrieve and prepare training data from the database.

    Args:
        session: SQLAlchemy database session instance

    Returns:
        Tuple containing features DataFrame and target DataFrame
    """
    # Get all answer rows with their associated answers
    answer_rows = session.query(AnswerRow).all()

    # Prepare data structure for features and targets
    data = []

    for row in answer_rows:
        # Get the board program ID (target) from the questionnaire
        board_program_id = row.questionnaire.board_program_id

        # Create a dict to store this answer row's features
        row_data = {"board_program_id": board_program_id}

        # Add each answer's choice as a feature
        for answer in row.answers:
            # Get the question from the choice
            question = answer.choice.question
            question_key = f"q_{question.id}"

            # Store the choice index as the feature value
            row_data[question_key] = answer.choice.order_index

        data.append(row_data)

    # Convert to DataFrame
    df = pd.DataFrame(data)

    if df.empty:
        raise ValueError("No training data found in the database")

    # Separate features and target
    X = df.drop("board_program_id", axis=1)
    y = df["board_program_id"]

    return X, y


def compute_confusion_matrix(y_true: np.ndarray, y_pred: np.ndarray):
    # Create a mapping of IDs to names
    # id_to_name = {bp.id: bp.name for bp in board_programs}

    # Get unique classes
    classes = sorted(np.unique(np.concatenate([y_true, y_pred])))
    # class_names = [id_to_name.get(c, f"ID {c}") for c in classes]

    # Calculate confusion matrix
    cm = confusion_matrix(y_true, y_pred, labels=classes)

    return cm


def train_model(session: Session) -> Dict[str, Any]:
    """
    Train the KNN model with grid search for hyperparameter tuning and save it.

    Args:
        session: SQLAlchemy database session instance

    Returns:
        Dictionary with training results
    """

    # Get training data
    X, y = get_training_data(session)

    # Get board programs for recommendations
    board_programs = session.query(BoardProgram).all()

    # Create and train the model
    recommender = KNNRecommender()
    processor = DataProcessor()

    # Store feature names for predictions
    recommender.feature_names = X.columns.tolist()

    # Process data
    X_processed, y_array = processor.prepare_data(X, y)

    # Split data
    X_train, X_test, y_train, y_test = train_test_split(
        X_processed, y_array, test_size=0.2, random_state=42, stratify=y_array
    )

    # Define parameter grid
    param_grid = {
        "n_neighbors": [3, 5, 7, 9, 11],
        "weights": ["uniform", "distance"],
        "metric": ["euclidean", "manhattan", "cosine"],
    }

    # Perform grid search
    grid_search = GridSearchCV(
        recommender.model, param_grid, cv=5, scoring="accuracy", n_jobs=-1
    )
    grid_search.fit(X_train, y_train)

    # Update model with best parameters
    recommender.model = grid_search.best_estimator_
    recommender.is_fitted = True

    # Save processor within the recommender
    recommender.processor = processor

    # Evaluate on test set
    y_pred = recommender.model.predict(X_test)
    accuracy = accuracy_score(y_test, y_pred)
    report = classification_report(y_test, y_pred, output_dict=True)

    # Get unique classes for labels
    classes = sorted(np.unique(np.concatenate([y_test, y_pred])))
    # Calculate confusion matrix
    cm = confusion_matrix(y_test, y_pred, labels=classes)

    # Save the model to disk
    # We only need to save the model components that are required for prediction
    model_data = {
        "model": recommender.model,
        "scaler": processor.scaler,
        "is_fitted": True,
    }
    joblib.dump(model_data, MODEL_PATH)

    # Save feature names separately
    joblib.dump(recommender.feature_names, FEATURE_NAMES_PATH)

    # Save board programs data (needed for recommendations)
    board_programs_data = [
        {
            "id": program.id,
            "name": program.name,
            "long_name": program.long_name,
            "college_name": program.college.name,
        }
        for program in board_programs
    ]

    joblib.dump(board_programs_data, BOARD_PROGRAMS_PATH)

    # Save training report for sending to analysis
    training_report = {
        "confusion_matrix": {"data": cm, "labels": classes},
        "classification_report": report,
    }
    joblib.dump(training_report, TRAINING_REPORT_PATH)

    # Return training results
    return {
        "best_params": grid_search.best_params_,
        "accuracy": float(accuracy),  # Ensure it's JSON serializable
        "classification_report": report,
        "model_path": MODEL_PATH,
        "feature_names_path": FEATURE_NAMES_PATH,
        "board_programs_path": BOARD_PROGRAMS_PATH,
    }
