<?php

namespace App\Http\Resources;

use App\MyLibrary\Interfaces\MyNoDataResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NoDataResource extends JsonResource implements MyNoDataResource
{
    /**
     * NoDataResource constructor.
     * @param array $resource
     */
    public function __construct($resource = [])
    {
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        parent::toArray($request);

        return [];
    }
}
