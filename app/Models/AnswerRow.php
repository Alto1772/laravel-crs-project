<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerRow extends Model
{
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }
}
