<?php

namespace App\MyLibrary\Interfaces;

interface MyRequest
{
    /**
     * @param array|null $keys
     * @return mixed
     */
    public function all(?array $keys = null);
}
