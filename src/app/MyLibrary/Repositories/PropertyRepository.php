<?php

namespace App\MyLibrary\Repositories;

use App\MyLibrary\Interfaces\MyPropertyModel;
use App\MyLibrary\Interfaces\MyPropertyRepository;

class PropertyRepository extends BaseRepository implements MyPropertyRepository
{
    public function __construct(MyPropertyModel $obj)
    {
        $this->model = $obj;
    }
}
