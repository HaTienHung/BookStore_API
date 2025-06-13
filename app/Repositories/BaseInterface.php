<?php

namespace App\Repositories;

interface BaseInterface
{
  public function all(array $columns = array('*'));

  public function updateOrCreate(array $keyNeedUpdate, array $data);

  public function paginate(int $perPage = 15, array $columns = array('*'));

  public function create(array $data);

  public function update(array $data, int $id);

  public function updateV2(string $table, array $data, int $id);

  public function delete(int $id);

  public function find(int $id, array $columns = array('*'));

  public function findBy(string $field, string $value, array $columns = array('*'));

  public function createOrUpdate(array $data, array $condition = []);

  public function deleteBy(array $condition = []);

  public function getFirstBy(array $condition = [], array $select = ['*'], array $with = []);

  public function findById($id, array $with = []);

  public function getModel();

  public function getFirstByWithTrash(array $condition = [], array $select = []);

  public function findAllById(string $field, array $id, array $columns = ["*"]);
}
