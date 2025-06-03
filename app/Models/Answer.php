<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $fillable = ['user_feedback'];

    protected $attributes = ['user_feedback' => ''];

    // public function question(): BelongsTo
    // {
    //     return $this->belongsTo(Question::class);
    // }

    public function choice(): BelongsTo
    {
        return $this->belongsTo(Choice::class);
    }

    public function answer_row(): BelongsTo
    {
        return $this->belongsTo(AnswerRow::class);
    }
}
