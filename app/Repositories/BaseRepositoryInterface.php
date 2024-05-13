<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

interface BaseRepositoryInterface
{
    /**
     * @param  array  $with
     * @param  array  $where
     * @param  string|null  $sortBy 
     * @param  string|null $sortDirection
     * @return Builder
     */
    public function index(array $where = [], array $with = [], string|null $sortBy, string|null $sortDirection): Builder;

    public function show(
        int $identifier,
        array $with = [],
        array $where = []
    ): mixed;
}
