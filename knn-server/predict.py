import os
import joblib
import pandas as pd
import numpy as np
from typing import Dict, List, Any
from .models import KNNRecommender, DataProcessor
from .models import MODEL_PATH, FEATURE_NAMES_PATH, BOARD_PROGRAMS_PATH


def load_model() -> KNNRecommender:
    """
    Load the trained KNN model from disk.

    Returns:
        Loaded KNN recommender model
    """
    recommender = KNNRecommender()

    # Load model data
    model_data = joblib.load(MODEL_PATH)

    recommender.model = model_data["model"]
    recommender.is_fitted = model_data["is_fitted"]

    # Create processor with loaded scaler
    processor = DataProcessor()
    processor.scaler = model_data["scaler"]
    recommender.processor = processor

    # Load feature names
    recommender.feature_names = joblib.load(FEATURE_NAMES_PATH)

    return recommender


def load_board_programs() -> List[Dict[str, Any]]:
    """
    Load the saved board programs data from disk.

    Returns:
        List of board program info dictionaries
    """
    board_programs = joblib.load(BOARD_PROGRAMS_PATH)

    return board_programs


def get_recommendations(answers_dict: Dict[int, int]) -> List[Dict[str, Any]]:
    """
    Generate board program recommendations based on user answers.

    Args:
        answers_dict: Dictionary mapping question IDs to choice indices

    Returns:
        List of recommendations with program details and scores
    """
    # Load model and board programs
    try:
        recommender = load_model()
        board_programs = load_board_programs()
    except (FileNotFoundError, IOError):
        # If model files don't exist, return an error message
        return {"error": "Model not trained. Please train the model first."}

    # Get predictions
    predictions = recommender.predict(answers_dict)

    # Create recommendation list
    recommendations = []
    for program in board_programs:
        score = predictions.get(program["id"], 0.0)
        recommendations.append(
            {
                "id": program["id"],
                "name": program["name"],
                "long_name": program["long_name"],
                "college_name": program["college_name"],
                "score": float(score),  # Ensure JSON serializable
                "percentage": round(float(score) * 100, 2),
            }
        )

    # Sort by score descending
    recommendations.sort(key=lambda x: x["score"], reverse=True)

    return recommendations
