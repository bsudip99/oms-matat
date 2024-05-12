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
   * @param  string  $sortBy
   * @param  string  $sortDirection
   * @return Builder
   */
  public function index(array $where = [], array $with = [], string $sortBy = 'created_at', string $sortDirection = 'desc'): Builder
  {
    return $this->builder->where($where)->with($with)->orderBy($sortBy, $sortDirection);
  }

  /**
   * @param  array  $data
   * @return mixed
   *
   * @throws Exception
   */
  public function store(array $data): mixed
  {
    DB::beginTransaction();
    try {
      $data = $this->builder->create($data);
    } catch (Exception $exception) {
      DB::rollBack();
      throw $exception;
    }
    DB::commit();

    return $data;
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

  /**
   * @param  array  $data
   * @param  int  $identifier
   * @return mixed
   *
   * @throws Exception
   */
  public function update(array $data, int $identifier): mixed
  {
    DB::beginTransaction();
    try {
      $updateData = $this->builder->findOrFail($identifier);
      $updateData->update($data);
    } catch (Exception $exception) {
      DB::rollBack();
      throw $exception;
    }
    DB::commit();

    return $updateData;
  }

  /**
   * @param  int  $identifier
   * @param  array  $where
   * @return mixed
   *
   * @throws Exception
   */
  public function delete(int $identifier, array $where = []): mixed
  {
    DB::beginTransaction();
    try {
      $data = $this->builder->where($where)->findOrFail($identifier);
      $data->delete();
    } catch (Exception $exception) {
      DB::rollBack();
      throw $exception;
    }
    DB::commit();

    return $data;
  }


  /**
   *
   * @param  array  $where
   * @return mixed
   *
   * @throws Exception
   */
  public function getLatestId(array $where = []): mixed
  {
    return $this->builder->where($where)->latest()->value('id');
  }

  /**
   *
   * @param  array  $where
   * @return mixed
   *
   * @throws Exception
   */
  public function getLatestIdByDynamicOrder(array $where = [], string $order = 'id', $withTrash = false): mixed
  {
    $data = $this->builder->where($where);

    if ($withTrash) {
      $data->withTrashed();
    }

    return $data->latest($order)->value('id');
  }

  /**
   *
   * @param  array  $where
   * @return mixed
   *
   * @throws Exception
   */
  public function getDataCount(array $where = []): mixed
  {
    return $this->builder->where($where)->count();
  }
}
