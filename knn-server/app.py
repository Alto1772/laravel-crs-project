from flask import Flask, jsonify, request
from flask_sqlalchemy import SQLAlchemy
from .database import get_database_uri, db
import os

from . import train, predict, analysis
from .models import MODEL_PATH


def create_app():
    app = Flask(__name__)

    ## --- Database ---
    app.config["SQLALCHEMY_DATABASE_URI"] = get_database_uri()
    # app.config["SQLALCHEMY_ECHO"] = True
    # app.config["SQLALCHEMY_TRACK_MODIFICATIONS"] = False
    db.init_app(app)

    ## --- Routes ---
    @app.route("/")
    def route_index():
        return jsonify({"message": "KNN Board Program Recommendation System API"})

    @app.route("/train", methods=["POST"])
    def route_train():
        """Train the KNN model and save it to disk"""
        try:
            result = train.train_model(db.session)
            return jsonify(
                {
                    "status": "success",
                    "message": "Model trained successfully",
                    "details": {
                        "accuracy": result["accuracy"],
                        "best_params": result["best_params"],
                        "classification_report": result["classification_report"],
                    },
                }
            )
        except Exception as e:
            app.logger.error(f"Error training model: {str(e)}")
            return (
                jsonify(
                    {"status": "error", "message": f"Failed to train model: {str(e)}"}
                ),
                500,
            )

    @app.route("/predict", methods=["POST"])
    def route_predict():
        """Generate recommendations based on user answers"""
        try:
            # Extract user answers from POST request
            data = request.get_json()
            if not data or "user_answers" not in data:
                return (
                    jsonify({"status": "error", "message": "No user answers provided"}),
                    400,
                )

            user_answers = data["user_answers"]

            # Convert string keys to integers if needed
            user_answers = {int(k): int(v) for k, v in user_answers.items()}

            # Get predictions
            recommendations = predict.get_recommendations(user_answers)

            # Check if error occurred
            if isinstance(recommendations, dict) and "error" in recommendations:
                return (
                    jsonify({"status": "error", "message": recommendations["error"]}),
                    404,
                )

            return jsonify({"status": "success", "recommendations": recommendations})

        except Exception as e:
            app.logger.error(f"Error making prediction: {str(e)}")
            return (
                jsonify(
                    {
                        "status": "error",
                        "message": f"Failed to generate recommendations: {str(e)}",
                    }
                ),
                500,
            )

    @app.route("/analysis")
    def route_analysis():
        """Generate visual analysis of the recommendation system"""
        try:
            analysis_data = analysis.generate_analysis(db.session)

            # Check if error occurred
            if "error" in analysis_data:
                return (
                    jsonify({"status": "error", "message": analysis_data["error"]}),
                    500,
                )

            return jsonify({"status": "success", "analysis": analysis_data})

        except Exception as e:
            app.logger.error(f"Error generating analysis: {str(e)}")
            return (
                jsonify(
                    {
                        "status": "error",
                        "message": f"Failed to generate analysis: {str(e)}",
                    }
                ),
                500,
            )

    @app.route("/status")
    def route_status():
        """Check if model is trained and ready"""
        model_exists = MODEL_PATH.exists()

        return jsonify(
            {
                "status": "ready" if model_exists else "not_trained",
                "model_path": MODEL_PATH if model_exists else None,
            }
        )

    return app
