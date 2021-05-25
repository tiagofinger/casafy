<?php

namespace App\MyLibrary\Repositories;

use App\MyLibrary\Classes\MyModelAbstract;
use App\MyLibrary\Interfaces\MyModel;
use App\MyLibrary\Interfaces\MyRepository;

abstract class BaseRepository implements MyRepository
{
    /**
     * @var MyModelAbstract
     */
    protected MyModelAbstract $model;

    /**
     * BaseRepository constructor.
     * @param MyModelAbstract $obj
     */
    protected function __construct(MyModelAbstract $obj)
    {
        $this->model = $obj;
    }

    /**
     * @return \ArrayAccess
     */
    public function all(): \ArrayAccess
    {
        return $this->model->all();
    }

    /**
     * @param int $id
     * @return MyModelAbstract
     */
    public function find(int $id): MyModelAbstract
    {
        return $this->model->find($id);
    }

    /**
     * @param int $id
     * @return MyModel
     */
    public function findOrFail(int $id): MyModelAbstract
    {
        return $this->model->findOrFail($id);
    }

    /**
     * @param array $attributes
     * @return MyModel
     */
    public function save(array $attributes): MyModelAbstract
    {
        $this->model->fill($attributes)
            ->save();

        return $this->model;
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return MyModelAbstract
     */
    public function update(int $id, array $attributes): MyModelAbstract
    {
        $data = $this->model->findOrFail($id);
        $data->update($attributes);

        return $data;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return $this->model->destroy($id);
    }
}
