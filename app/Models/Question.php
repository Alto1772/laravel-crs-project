<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Question extends Model
{
    protected $fillable = ['title', 'order_index'];

    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function choices(): HasMany
    {
        return $this->hasMany(Choice::class);
    }

    // public function answers(): HasMany
    // {
    //     return $this->hasMany(Answer::class);
    // }

    public function answers(): HasManyThrough
    {
        return $this->hasManyThrough(Answer::class, Choice::class);
    }
}
