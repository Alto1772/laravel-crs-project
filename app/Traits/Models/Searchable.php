<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearch(Builder $builder, string $query)
    {
        if (property_exists($this, 'searchableColumns')) {
            return $builder->when(
                $query,
                fn (Builder $builder, string $query) => $builder->whereAny($this->searchableColumns, 'LIKE', "%{$query}%")
            );
        }

        return $builder;
    }
}
