import io
import joblib
import numpy as np
import pandas as pd
import seaborn as sns
from sklearn.manifold import TSNE
from sklearn.decomposition import PCA
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import confusion_matrix
from typing import Dict, List, Any, Tuple
import matplotlib

matplotlib.use("agg")

import matplotlib.pyplot as plt

from sqlalchemy.orm import Session
from .models import DataProcessor
from .database import BoardProgram
from .train import get_training_data
from .models import MODEL_PATH, TRAINING_REPORT_PATH


def figure_to_svg(fig):
    """Convert a matplotlib figure to an SVG string"""
    svg_io = io.StringIO()
    fig.savefig(svg_io, format="svg", bbox_inches="tight")
    plt.close(fig)
    svg_io.seek(0)
    svg_data = svg_io.getvalue()
    return svg_data


def generate_class_distribution(
    X: pd.DataFrame, y: pd.Series, board_programs: List[BoardProgram]
) -> str:
    """
    Generate an SVG visualization of class distribution.

    Args:
        X: Features DataFrame
        y: Target Series
        board_programs: List of board program objects

    Returns:
        SVG string visualization
    """
    # Create a mapping of IDs to names
    id_to_name = {bp.id: bp.name for bp in board_programs}

    # Count the frequency of each board program
    counts = y.value_counts()

    # Map IDs to names for display
    labels = [id_to_name.get(idx, f"ID {idx}") for idx in counts.index]

    # Create the plot
    fig, ax = plt.subplots(figsize=(10, 6))
    bars = ax.bar(labels, counts.values)

    # Add labels and title
    ax.set_xlabel("Board Program")
    ax.set_ylabel("Number of Responses")
    ax.set_title("Distribution of Responses by Board Program")
    ax.set_xticklabels(labels, rotation=45, ha="right")

    for bar in bars:
        height = bar.get_height()
        ax.text(
            bar.get_x() + bar.get_width() / 2.0,
            height + 0.1,
            int(height),
            ha="center",
            va="bottom",
        )

    plt.tight_layout()

    # Convert to SVG
    return figure_to_svg(fig)


def plot_confusion_matrix(
    cm: np.ndarray, board_programs: List[BoardProgram], classes: List[str]
) -> plt.Figure:
    """
    Generate an SVG visualization of confusion matrix.

    Args:
        y_true: True labels
        y_pred: Predicted labels
        board_programs: List of board program objects

    Returns:
        SVG string visualization
    """
    # Create a mapping of IDs to names
    id_to_name = {bp.id: bp.name for bp in board_programs}

    class_names = [id_to_name.get(c, f"ID {c}") for c in classes]

    # Create plot
    fig, ax = plt.subplots(figsize=(12, 10))
    sns.heatmap(
        cm,
        annot=True,
        fmt="d",
        cmap="Blues",
        xticklabels=class_names,
        yticklabels=class_names,
        ax=ax,
    )

    ax.set_title("Confusion Matrix")
    ax.set_ylabel("True Label")
    ax.set_xlabel("Predicted Label")
    plt.xticks(rotation=45, ha="right")
    plt.yticks(rotation=45)
    plt.tight_layout()

    return figure_to_svg(fig)


def generate_feature_importance(X: pd.DataFrame, y: pd.Series) -> str:
    """
    Generate an SVG visualization of feature importance.

    Args:
        X: Features DataFrame
        y: Target Series

    Returns:
        SVG string visualization
    """
    # Train a random forest to get feature importance
    rf = RandomForestClassifier(n_estimators=100, random_state=42)
    rf.fit(X, y)

    # Get feature importance
    importances = rf.feature_importances_
    indices = np.argsort(importances)[::-1]

    # Get feature names
    feature_names = X.columns

    # Plot top 15 features (or all if less than 15)
    n_features = min(15, len(feature_names))

    # Create the plot
    fig, ax = plt.subplots(figsize=(12, 8))

    # Create bars
    ax.bar(range(n_features), importances[indices][:n_features], align="center")

    # Add feature names as x-axis labels
    ax.set_xticks(range(n_features))
    ax.set_xticklabels(
        [feature_names[i] for i in indices[:n_features]], rotation=45, ha="right"
    )

    # Add labels and title
    ax.set_title("Feature Importance of Questions")
    ax.set_xlabel("Features")
    ax.set_ylabel("Importance Score")
    plt.tight_layout()

    # Convert to SVG
    return figure_to_svg(fig)


def generate_cluster_visualization(
    X: pd.DataFrame, y: pd.Series, board_programs: List[BoardProgram]
) -> str:
    """
    Generate an SVG visualization of the data clusters.

    Args:
        X: Features DataFrame
        y: Target Series
        board_programs: List of board program objects

    Returns:
        SVG string visualization
    """
    # Process the data
    processor = DataProcessor()
    X_processed, y_array = processor.prepare_data(X, y)

    # Create a mapping of IDs to names and colors
    id_to_name = {bp.id: bp.name for bp in board_programs}
    unique_targets = np.unique(y_array)
    colors = plt.cm.rainbow(np.linspace(0, 1, len(unique_targets)))

    # Use PCA for initial dimensionality reduction if features are high-dimensional
    if X_processed.shape[1] > 50:
        X_reduced = PCA(n_components=50).fit_transform(X_processed)
    else:
        X_reduced = X_processed

    # Use t-SNE for final 2D visualization
    X_embedded = TSNE(n_components=2, random_state=42).fit_transform(X_reduced)

    # Create the plot
    fig, ax = plt.subplots(figsize=(12, 10))

    # Plot each class with a different color
    for i, target in enumerate(unique_targets):
        indices = np.where(y_array == target)
        ax.scatter(
            X_embedded[indices, 0],
            X_embedded[indices, 1],
            c=[colors[i]],
            label=id_to_name.get(target, f"ID {target}"),
            alpha=0.7,
        )

    ax.set_title("t-SNE Visualization of Board Program Responses")
    ax.legend(title="Board Program")

    # Convert to SVG
    return figure_to_svg(fig)


def generate_analysis(session: Session) -> Dict[str, Any]:
    """
    Generate visual analysis of the recommendation system.

    Args:
        session: SQLAlchemy database session instance

    Returns:
        Dictionary with SVG visualizations
    """

    # Check if model exists
    model_exists = MODEL_PATH.exists()

    # Get data
    X, y = get_training_data(session)
    board_programs = session.query(BoardProgram).all()

    # Load training report
    if model_exists and TRAINING_REPORT_PATH.exists():
        training_report = joblib.load(TRAINING_REPORT_PATH)
    else:
        training_report = None

    # Generate visualizations
    try:
        result = {
            "class_distribution": generate_class_distribution(X, y, board_programs),
            # "feature_importance": generate_feature_importance(X, y),
            "cluster_visualization": generate_cluster_visualization(
                X, y, board_programs
            ),
            "confusion_matrix": None,
            "classification_report": None,
            "model_exists": model_exists,
            "data_points": len(X),
            "features": len(X.columns),
            "classes": len(y.unique()),
        }

        if training_report is not None:
            cm = training_report["confusion_matrix"]

            result["confusion_matrix"] = plot_confusion_matrix(
                cm["data"], board_programs, cm["labels"]
            )
            result["classification_report"] = training_report["classification_report"]

        return result
    except Exception as e:
        return {"error": f"Error generating analysis: {str(e)}"}
