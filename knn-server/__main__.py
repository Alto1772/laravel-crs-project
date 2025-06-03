from . import app as main_app, train, database, models
from environs import Env
import sys
import os
from sqlalchemy import create_engine
from sqlalchemy.orm import Session

env = Env()
env.read_env()


def prepare_train():
    engine = create_engine(database.get_database_uri())
    with Session(engine) as session:
        train.train_model(session)


if len(sys.argv) > 1:
    if sys.argv[1] == "train":
        print("Regenerating training data for KNN...")
        prepare_train()
        exit()

# Check if training data is present
if not models.MODEL_PATH.exists():
    print("Generating training data for KNN...")
    prepare_train()

app = main_app.create_app()

app.run(
    host=env("HOST", "localhost"),
    port=env.int("PORT", 5000),
    debug=env.bool("APP_DEBUG", False),
)
