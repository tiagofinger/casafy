<?php

namespace App\MyLibrary\Interfaces;

interface MyRepository
{
    /**
     * @param array $options
     * @return mixed
     */
    public function save(array $options);

    /**
     * @param int $id
     * @param array $key
     * @return mixed
     */
    public function update(int $id, array $key);

    /**
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id);

    /**
     * @return mixed
     */
    public function all();

    /**
     * @param int $id
     * @return mixed
     */
    public function findOrFail(int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id);
}
