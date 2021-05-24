<?php


namespace App\MyLibrary\Interfaces;

use App\MyLibrary\Interfaces\MyRepository;


interface MyUserRepository extends MyRepository
{
    public function properties(int $id): \ArrayAccess;
}
