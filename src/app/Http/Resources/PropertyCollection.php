<?php

namespace App\Http\Resources;

use App\MyLibrary\Interfaces\MyCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PropertyCollection extends ResourceCollection implements MyCollection
{
    /**
     * PropertyCollection constructor.
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
            'data' => $this->collection
        ];
    }
}
