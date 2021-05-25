<?php

namespace App\MyLibrary\Interfaces;

interface MyCollection
{
    /**
     * @param ...$parameters
     * @return mixed
     */
    public static function make(...$parameters);
}
