<?php

namespace App\Models;

use App\Traits\Models\Neighborable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Staudenmeir\EloquentHasManyDeep;

class Questionnaire extends Model
{
    use EloquentHasManyDeep\HasRelationships;
    use Neighborable;

    // protected $with = ['board_program.college', 'questions.choices'];

    public function board_program(): BelongsTo
    {
        return $this->belongsTo(BoardProgram::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    // public function answers(): HasManyThrough
    // {
    //     return $this->hasManyThrough(Answer::class, Question::class);
    // }
    public function answers(): EloquentHasManyDeep\HasManyDeep
    {
        return $this->hasManyDeep(Answer::class, [Question::class, Choice::class]);
    }

    public function answer_rows(): HasMany
    {
        return $this->hasMany(AnswerRow::class);
    }
}
