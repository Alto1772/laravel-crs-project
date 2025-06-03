import numpy as np
import pandas as pd
from sklearn.neighbors import KNeighborsClassifier
from sklearn.preprocessing import StandardScaler, OneHotEncoder
from typing import Dict, Tuple
from pathlib import Path

# Constants
MODEL_PATH = Path(__file__).parent.absolute() / "knn_model.joblib"
FEATURE_NAMES_PATH = Path(__file__).parent.absolute() / "feature_names.joblib"
BOARD_PROGRAMS_PATH = Path(__file__).parent.absolute() / "board_programs.joblib"
TRAINING_REPORT_PATH = Path(__file__).parent.absolute() / "training_report.joblib"


# Data Processing Layer
class DataProcessor:
    """Handles data preparation and feature engineering."""

    def __init__(self):
        """Initialize the data processor."""
        self.scaler = StandardScaler()
        self.encoder = OneHotEncoder(sparse_output=False)

    def prepare_data(
        self, X: pd.DataFrame, y: pd.Series
    ) -> Tuple[np.ndarray, np.ndarray]:
        """
        Process raw data for model training.

        Args:
            X: Features DataFrame
            y: Target Series

        Returns:
            Tuple of processed features and targets
        """
        # Handle missing values by filling with the most common value per question
        X_filled = X.apply(lambda col: col.fillna(col.mode()[0]), axis=0)

        # Scale numerical features
        X_scaled = self.scaler.fit_transform(X_filled)

        return X_scaled, y.values

    def transform_new_data(self, X_new: pd.DataFrame) -> np.ndarray:
        """
        Transform new data using the fitted preprocessor.

        Args:
            X_new: New data to transform

        Returns:
            Processed features ready for prediction
        """
        # Handle missing values
        X_filled = X_new.apply(
            lambda col: col.fillna(col.mode()[0] if not col.mode().empty else 0), axis=0
        )

        # Apply the same scaling
        return self.scaler.transform(X_filled)


# Model Layer
class KNNRecommender:
    """KNN-based board program recommendation model."""

    def __init__(self):
        """Initialize the KNN recommender."""
        self.model = KNeighborsClassifier()
        self.is_fitted = False
        self.processor = DataProcessor()
        self.feature_names = None

    def predict(self, answers_dict: Dict[int, int]) -> Dict[int, float]:
        """
        Predict probabilities for board programs based on answers.

        Args:
            answers_dict: Dictionary mapping question IDs to choice indices

        Returns:
            Dictionary mapping board program IDs to probability scores
        """
        if not self.is_fitted:
            raise ValueError("Model must be trained before making predictions")

        # Convert answers to feature format
        features = {}
        for q_id, choice_idx in answers_dict.items():
            features[f"q_{q_id}"] = choice_idx

        # Create DataFrame with the same structure as training data
        X_new = pd.DataFrame([features])

        # Ensure all expected features are present
        for feat in self.feature_names:
            if feat not in X_new.columns:
                X_new[feat] = np.nan

        # Reorder columns to match training data
        X_new = X_new[self.feature_names]

        # Process new data
        X_processed = self.processor.transform_new_data(X_new)

        # Get class probabilities
        proba = self.model.predict_proba(X_processed)[0]

        # Map probabilities to board program IDs
        result = {}
        for i, prob in enumerate(proba):
            program_id = self.model.classes_[i]
            result[int(program_id)] = float(prob)

        return result
