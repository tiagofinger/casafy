<?php

namespace App\MyLibrary\Classes;

use App\MyLibrary\Interfaces\MyModel;
use Illuminate\Database\Eloquent\Model;

abstract class MyModelAbstract extends Model implements MyModel
{
}
