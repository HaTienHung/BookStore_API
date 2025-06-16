<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


abstract class BaseRepository implements BaseInterface
{

  public function __construct(
    protected Model $model,
  ) {
    $this->model = $model;
  }

  public function all(array $columns = ['*']): \Illuminate\Database\Eloquent\Collection
  {
    return $this->model->get($columns);
  }

  public function updateOrCreate(array $keyNeedUpdate, array $data): Model
  {
    return $this->model->updateOrCreate($keyNeedUpdate, $data);
  }

  public function paginate(int $perPage = 15, array $columns = ['*']): \Illuminate\Contracts\Pagination\LengthAwarePaginator
  {
    return $this->model->paginate($perPage, $columns);
  }

  public function create(array $data): Model
  {
    return $this->model->create($data);
  }

  public function update(array $data, mixed $id, string $attribute = "id"): int
  {
    return $this->model->where($attribute, $id)->update($data);
  }

  public function updateV2(string $table, array $data, mixed $id, string $attribute = "id"): int
  {
    return DB::table($table)->where($attribute, $id)->update($data);
  }

  public function delete(mixed $id): int
  {
    return $this->model->destroy($id);
  }

  public function find(mixed $id, array $columns = ["*"])
  {
    return $this->model->find($id, $columns);
  }

  public function findAllById(string $field, array $id, array $columns = ["*"])
  {
    return $this->model->whereIntegerInRaw($field, $id)->get($columns);
  }

  public function findAllBy(array $condition = [], array $with = [])
  {
    $query = $this->model->newQuery();
    $this->applyConditions($condition, $query);
    $query->with($with);
    $data = $query->get();
    return $data;
  }

  public function findBy(string $field, mixed $value, array $columns = ['*']): ?Model
  {
    return $this->model->where($field, $value)->first($columns);
  }

  public function findById(mixed $id, array $with = []): ?Model
  {
    $query = $this->model->newQuery();

    if (!empty($with)) {
      $query->with($with);
    }

    return $query->where('id', $id)->first();
  }

  public function getFirstBy(array $condition = [], array $select = ['*'], array $with = []): ?Model
  {
    $query = $this->model->newQuery();

    if (!empty($with)) {
      $query->with($with);
    }

    $this->applyConditions($condition, $query);

    return empty($select) ? $query->first() : $query->select($select)->first();
  }

  protected function applyConditions(array $where, $query = null): void
  {
    $targetQuery = $query ?? $this->model;

    foreach ($where as $field => $value) {
      if (is_array($value)) {
        [$field, $condition, $val] = $value;
        $targetQuery = match (strtoupper($condition)) {
          'IN' => $targetQuery->whereIn($field, $val),
          'NOT_IN' => $targetQuery->whereNotIn($field, $val),
          default => $targetQuery->where($field, $condition, $val),
        };
      } else {
        $targetQuery = $targetQuery->where($field, $value);
      }
    }

    if ($query === null) {
      $this->model = $targetQuery;
    }
  }

  public function createOrUpdate(array $data, array $condition = []): Model|false
  {
    if (is_array($data)) {
      $item = empty($condition) ?
        new $this->model() :
        $this->getFirstBy($condition) ?? new $this->model();

      $item->fill($data);
    } elseif ($data instanceof Model) {
      $item = $data;
    } else {
      return false;
    }

    return $item->save() ? $item : false;
  }

  public function deleteBy(array $condition = []): bool
  {
    $query = $this->model->newQuery();
    $this->applyConditions($condition, $query);
    $data = $query->get();

    if ($data->isEmpty()) {
      return false;
    }

    foreach ($data as $item) {
      $item->delete();
    }

    return true;
  }

  public function deleteByIds(string $field, array $ids)
  {
    $query = $this->model->newQuery();
    return $query->whereIntegerInRaw($field, $ids)->delete();
  }

  public function restoreByIds(string $field, array $ids)
  {
    $query = $this->model->newQuery();
    return $query->onlyTrashed()->whereIntegerInRaw($field, $ids)->restore();
  }

  public function getFirstByWithTrash(array $condition = [], array $select = []): ?Model
  {
    $query = $this->model->newQuery();
    $this->applyConditions($condition, $query);
    $query->withTrashed();

    return empty($select) ?
      $query->first() :
      $query->select($select)->first();
  }
  public function getAllByWithTrash(array $condition = [], array $select = ['*'])
  {
    $query = $this->model->newQuery();

    if (!empty($condition)) {
      $query->where($condition);
    }

    return $query->onlyTrashed()->select($select)->get();
  }
}
