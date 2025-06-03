<?php

namespace App\Models;

use App\Observers\CollegeObserver;
use App\Traits\Models\Searchable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

#[ObservedBy(CollegeObserver::class)]
class College extends Model
{
    use Searchable;

    protected $searchableColumns = ['name', 'long_name'];

    protected $fillable = ['name', 'long_name', 'description', 'image'];

    public function board_programs(): HasMany
    {
        return $this->hasMany(BoardProgram::class);
    }

    public function questionnaires(): HasManyThrough
    {
        return $this->hasManyThrough(Questionnaire::class, BoardProgram::class);
    }
}
