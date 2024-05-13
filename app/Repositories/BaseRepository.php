<?php

namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository implements BaseRepositoryInterface
{
  /**
   * @var Model
   */
  protected Model $builder;

  /**
   * @return string
   */
  abstract public function model(): string;

  public function __construct()
  {
    $this->makeModel(); // Corresponding modal instance
  }

  /**
   * @return void
   */
  private function makeModel()
  {
    $this->builder = app($this->model());
  }

  /**
   * @param  array  $where
   * @param  array  $with
   * @param  string|null  $sortBy 
   * @param  string|null $sortDirection
   * @return Builder
   */
  public function index(array $where = [], array $with = [], string|null $sortBy, string|null $sortDirection): Builder
  {
    $sortBy = $sortBy ?? 'id';
    $sortDirection = $sortDirection ?? 'asc';
    return $this->builder->where($where)->with($with)->orderBy($sortBy, $sortDirection);
  }

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
  ): mixed {
    return $this->builder
      ->where($where)
      ->with($with)
      ->findOrFail($identifier);
  }
}
