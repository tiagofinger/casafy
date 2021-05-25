<?php

namespace App\Http\Resources;

use App\MyLibrary\Interfaces\MyPropertyResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PropertyResource extends JsonResource implements MyPropertyResource
{
    /**
     * PropertyResource constructor.
     * @param array $resource
     */
    public function __construct($resource = [])
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        parent::toArray($request);

        return [
            'id' => $this->id,
            'address' => $this->address,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'total_area' => $this->total_area,
            'purchased' => $this->purchased,
            'value' => $this->value,
            'discount' => $this->discount,
            'owner_id' => $this->owner_id,
            'expired' => $this->expired,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
