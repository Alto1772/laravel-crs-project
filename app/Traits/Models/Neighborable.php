<?php

namespace App\Traits\Models;

/**
 * Provides next/previous record navigation functionality for Eloquent models
 *
 * @method self|null next() Get the subsequent record in ordering sequence
 * @method self|null previous() Get the preceding record in ordering sequence
 */
trait Neighborable
{
    /**
     * Retrieve the next record in the ordering sequence
     *
     * @return self|null
     *
     * @throws \Illuminate\Database\QueryException If column doesn't exist
     */
    public function next()
    {
        return static::where($this->getOrderColumn(), '>', $this->{$this->getOrderColumn()})
            ->orderBy($this->getOrderColumn(), 'asc')
            ->first();
    }

    /**
     * Retrieve the previous record in the ordering sequence
     *
     * @return self|null
     *
     * @throws \Illuminate\Database\QueryException If column doesn't exist
     */
    public function previous()
    {
        return static::where($this->getOrderColumn(), '<', $this->{$this->getOrderColumn()})
            ->orderBy($this->getOrderColumn(), 'desc')
            ->first();
    }

    /**
     * @return self|null
     *
     * @throws \Illuminate\Database\QueryException If column doesn't exist
     */
    public function nextId()
    {
        return static::select(['id'])
            ->where($this->getOrderColumn(), '>', $this->{$this->getOrderColumn()})
            ->orderBy($this->getOrderColumn(), 'asc')
            ->first()?->id;
    }

    /**
     * @return self|null
     *
     * @throws \Illuminate\Database\QueryException If column doesn't exist
     */
    public function previousId()
    {
        return static::select(['id'])
            ->where($this->getOrderColumn(), '<', $this->{$this->getOrderColumn()})
            ->orderBy($this->getOrderColumn(), 'desc')
            ->first()?->id;
    }

    /**
     * Determine the column used for ordering sequence
     *
     *
     * @see \App\Models\Traits\Neighborable::$neighborOrderColumn
     */
    protected function getOrderColumn(): string
    {
        return property_exists($this, 'neighborOrderColumn')
            ? $this->neighborOrderColumn
            : 'id';
    }
}
