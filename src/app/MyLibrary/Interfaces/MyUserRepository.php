<?php

namespace App\MyLibrary\Interfaces;

interface MyUserRepository extends MyRepository
{
    public function properties(int $id): \ArrayAccess;
}
