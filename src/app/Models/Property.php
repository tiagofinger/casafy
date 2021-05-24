<?php

namespace App\Models;

use App\MyLibrary\Classes\MyModelAbstract;
use App\MyLibrary\Interfaces\MyPropertyModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Property extends MyModelAbstract implements MyPropertyModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address',
        'bedrooms',
        'bathrooms',
        'total_area',
        'purchased',
        'value',
        'discount',
        'owner_id',
        'expired',
        'created_at'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:m',
        'updated_at' => 'datetime:Y-m-d H:i:m',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'total_area' => 'integer',
        'value' => 'float',
        'discount' => 'integer',
        'owner_id' => 'integer',
        'expired' => 'boolean',
        'purchased' => 'boolean',
    ];

    /**
     * @param $value
     * @return float|int
     */
    public function getValueAttribute($value)
    {
        return $value - ($value * ($this->discount / 100));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * If created_at exceeds 3 months, expired property should be changed to true
     */
    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($propertyModel) {
            $dateNow = Carbon::now();
            $dateCreated = Carbon::parse($propertyModel->created_at);

            if ($dateCreated->diff($dateNow)->m > 3) {
                $propertyModel->expired = true;
                $propertyModel->save();
            }
        });
    }
}
