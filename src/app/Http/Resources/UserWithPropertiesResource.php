<?php

namespace App\Http\Resources;

use App\MyLibrary\Interfaces\MyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWithPropertiesResource extends JsonResource implements MyResource
{
    /**
     * UserResource constructor.
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

        $attributes = $this->attributes([
            'id',
            'name',
            'email',
            'created_at',
            'updated_at'
        ]);

        return [
            'user' => [
                $attributes
            ],
            'properties' => [
                PropertyResource::collection($this->whenLoaded('properties')),
            ]
        ];
    }
}
