from sqlalchemy import ForeignKey
from sqlalchemy.orm import (
    DeclarativeBase,
    Mapped,
    mapped_column,
    relationship,
)
from flask_sqlalchemy import SQLAlchemy
from typing import List, Optional

def get_database_uri():
    from environs import env

    # TODO account for sqlite
    return "{}://{}:{}@{}:{}/{}".format(
        env("DB_CONNECTION"),
        env("DB_USERNAME"),
        env("DB_PASSWORD"),
        env("DB_HOST"),
        env("DB_PORT"),
        env("DB_DATABASE"),
    )


class Base(DeclarativeBase):
    pass

db = SQLAlchemy(model_class=Base)

class College(db.Model):
    __tablename__ = "colleges"

    id: Mapped[int] = mapped_column(primary_key=True)
    name: Mapped[str]
    long_name: Mapped[str]
    description: Mapped[str]

    board_programs: Mapped[List["BoardProgram"]] = relationship(
        back_populates="college", lazy="selectin"
    )


class BoardProgram(db.Model):
    __tablename__ = "board_programs"

    id: Mapped[int] = mapped_column(primary_key=True)
    name: Mapped[str]
    long_name: Mapped[str]
    college_id: Mapped[int] = mapped_column(ForeignKey("colleges.id"))

    college: Mapped["College"] = relationship(
        back_populates="board_programs", lazy="joined"
    )
    questionnaires: Mapped[List["Questionnaire"]] = relationship(
        back_populates="board_program", lazy="selectin"
    )


class Questionnaire(db.Model):
    __tablename__ = "questionnaires"

    id: Mapped[int] = mapped_column(primary_key=True)
    board_program_id: Mapped[int] = mapped_column(ForeignKey("board_programs.id"))

    board_program: Mapped["BoardProgram"] = relationship(
        back_populates="questionnaires", lazy="joined"
    )
    questions: Mapped[List["Question"]] = relationship(
        back_populates="questionnaire", lazy="selectin"
    )
    # Don't use lazy="selectin" here
    answer_rows: Mapped[List["AnswerRow"]] = relationship(
        back_populates="questionnaire"
    )


class Question(db.Model):
    __tablename__ = "questions"

    id: Mapped[int] = mapped_column(primary_key=True)
    questionnaire_id: Mapped[int] = mapped_column(ForeignKey("questionnaires.id"))
    title: Mapped[str]
    order_index: Mapped[int]  # index starts at 0

    questionnaire: Mapped["Questionnaire"] = relationship(
        back_populates="questions", lazy="joined"
    )
    choices: Mapped[List["Choice"]] = relationship(
        back_populates="question", lazy="selectin"
    )


class Choice(db.Model):
    __tablename__ = "choices"

    id: Mapped[int] = mapped_column(primary_key=True)
    question_id: Mapped[int] = mapped_column(ForeignKey("questions.id"))
    order_index: Mapped[int]  # index starts at 0
    text: Mapped[str]
    is_correct: Mapped[bool]

    question: Mapped["Question"] = relationship(back_populates="choices", lazy="joined")
    answers: Mapped[List["Answer"]] = relationship(back_populates="choice")


class AnswerRow(db.Model):
    __tablename__ = "answer_rows"

    id: Mapped[int] = mapped_column(primary_key=True)
    questionnaire_id: Mapped[int] = mapped_column(ForeignKey("questionnaires.id"))

    questionnaire: Mapped["Questionnaire"] = relationship(
        back_populates="answer_rows", lazy="joined"
    )
    answers: Mapped[List["Answer"]] = relationship(
        back_populates="answer_row", lazy="selectin"
    )


class Answer(db.Model):
    __tablename__ = "answers"

    id: Mapped[int] = mapped_column(primary_key=True)
    question_id: Mapped[Optional[int]] = mapped_column(
        ForeignKey("questions.id")
    )  # unused, also this was my mistake for defining this
    choice_id: Mapped[int] = mapped_column(ForeignKey("choices.id"))
    answer_row_id: Mapped[int] = mapped_column(ForeignKey("answer_rows.id"))
    user_feedback: Mapped[str]  # unused, remnant from google forms csv export

    choice: Mapped["Choice"] = relationship(back_populates="answers", lazy="joined")
    answer_row: Mapped["AnswerRow"] = relationship(
        back_populates="answers", lazy="joined"
    )