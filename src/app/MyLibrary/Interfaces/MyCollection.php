<?php


namespace App\MyLibrary\Interfaces;


use ArrayAccess;

interface MyCollection
{
    /**
     * @param ...$parameters
     * @return mixed
     */
    public static function make(... $parameters);
}
