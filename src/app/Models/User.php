<?php

namespace App\Models;

use App\MyLibrary\Classes\MyModelAbstract;
use App\MyLibrary\Interfaces\MyUserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Models\Property;

class User extends MyModelAbstract implements MyUserModel
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:m',
        'updated_at' => 'datetime:Y-m-d H:i:m',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function properties()
    {
        return $this->hasMany(Property::class, 'owner_id');
    }
}
