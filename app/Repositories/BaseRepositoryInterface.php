<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

interface BaseRepositoryInterface
{
    /**
     * @param  array  $with
     * @param  array  $where
     * @return Builder
     */
    public function index(array $where = [], array $with = []): Builder;

    /**
     * @param  array  $data
     * @return mixed
     */
    public function store(array $data): mixed;

    /**
     * @param  array  $data
     * @param  int  $identifier
     * @return mixed
     */
    public function update(array $data, int $identifier): mixed;

    /**
     * @param  int  $identifier
     * @param  array  $with
     * @param  array  $where
     * @return mixed
     */
    public function show(
        int $identifier,
        array $with = [],
        array $where = []
    ): mixed;

    /**
     * @param  int  $identifier
     * @param  array  $where
     * @return mixed
     */
    public function delete(int $identifier, array $where = []): mixed;


    /**
     * 
     * @param  array  $where
     * @return mixed
     */
    public function  getLatestId(array $where = []): mixed;

}
