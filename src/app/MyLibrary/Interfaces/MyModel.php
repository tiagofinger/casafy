<?php

namespace App\MyLibrary\Interfaces;

use App\MyLibrary\Classes\MyModelAbstract;

interface MyModel
{
    /**
     * @param array $attributes
     * @return mixed
     */
    public function fill(array $attributes);

    /**
     * @param array $data
     * @return mixed
     */
    public static function all(array $data);
}
