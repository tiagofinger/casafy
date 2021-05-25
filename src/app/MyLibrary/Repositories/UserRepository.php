<?php

namespace App\MyLibrary\Repositories;

use App\MyLibrary\Interfaces\MyUserRepository;
use App\MyLibrary\Interfaces\MyUserModel;

class UserRepository extends BaseRepository implements MyUserRepository
{
    public function __construct(MyUserModel $obj)
    {
        $this->model = $obj;
    }

    /**
     * @return \ArrayAccess
     */
    public function properties(int $id): \ArrayAccess
    {
        return $this->model
            ->with('properties')
            ->where('id', $id)
            ->first();
    }
}
