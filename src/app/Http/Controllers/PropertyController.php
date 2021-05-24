<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyPurchasedRequest;
use App\Http\Resources\NoDataResource;
use App\Models\Property;
use App\Http\Requests\PropertyRequest;
use App\Http\Resources\PropertyResource;
use App\MyLibrary\Interfaces\MyCollection;
use App\MyLibrary\Interfaces\MyPropertyRepository;
use App\MyLibrary\Interfaces\MyResource;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PropertyCollection;

class PropertyController extends Controller
{
    /**
     * @var PropertyCollection
     */
    private PropertyCollection $propertyCollection;

    /**
     * @var PropertyResource
     */
    private PropertyResource $propertyResource;

    /**
     * @var NoDataResource
     */
    private NoDataResource $noDataResource;

    /**
     * @var MyPropertyRepository
     */
    private MyPropertyRepository $propertyRepository;

    /**
     * PropertyController constructor.
     * @param Property $propertyModel
     */
    public function __construct(
        PropertyCollection $propertyCollection,
        PropertyResource $propertyResource,
        NoDataResource $noDataResource,
        MyPropertyRepository $propertyRepository
    )
    {
        $this->propertyCollection = $propertyCollection;
        $this->propertyResource = $propertyResource;
        $this->noDataResource = $noDataResource;
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * @return PropertyCollection
     */
    public function index(): MyCollection
    {
        $properties = $this->propertyRepository->all();

        return $this->propertyCollection::make($properties);
    }

    /**
     * @param PropertyRequest $request
     * @return JsonResponse|object
     */
    public function store(PropertyRequest $request): MyResource
    {
        $properties = $this->propertyRepository->save($request->all());

        return $this->propertyResource::make($properties);
    }

    /**
     * @param int $id
     * @return PropertyResource
     */
    public function show(int $id): MyResource
    {
        $property = $this->propertyRepository->findOrFail($id);

        return $this->propertyResource::make($property);
    }

    /**
     * @param PropertyRequest $request
     * @param int $id
     * @return PropertyResource
     */
    public function update(PropertyRequest $request, int $id): MyResource
    {
        $property = $this->propertyRepository->update($id, $request->all());

        return $this->propertyResource::make($property);
    }

    /**
     * @param PropertyPurchasedRequest $request
     * @param int $id
     * @return MyResource
     */
    public function updatePurchased(PropertyPurchasedRequest $request, int $id): JsonResponse
    {
        $property = $this->propertyRepository->update($id, $request->all('purchased'));

        return ($this->noDataResource::make())
            ->response()
            ->setStatusCode(204);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $this->propertyRepository->destroy($id);

        return ($this->noDataResource::make())
            ->response()
            ->setStatusCode(204);
    }
}
