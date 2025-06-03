<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class BoardProgram extends Model
{
    protected $fillable = ['name', 'long_name'];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function questionnaires(): HasMany
    {
        return $this->hasMany(Questionnaire::class);
    }

    public function questions(): HasManyThrough
    {
        return $this->hasManyThrough(Question::class, Questionnaire::class);
    }

    public function fullName(string $delim = '|'): string
    {
        return "{$this->college->name} {$delim} {$this->name}";
    }

    public function getFullNameAttribute(): string
    {
        return $this->fullName();
    }
}
