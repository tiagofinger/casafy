<?php

namespace App\Http\Controllers;

use App\Http\Resources\PropertyResource;
use App\MyLibrary\Interfaces\MyNoDataResource;
use App\MyLibrary\Interfaces\MyPropertyCollection;
use App\MyLibrary\Interfaces\MyPropertyPurchasedRequest;
use App\MyLibrary\Interfaces\MyPropertyRepository;
use App\MyLibrary\Interfaces\MyPropertyRequest;
use App\MyLibrary\Interfaces\MyPropertyResource;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\PropertyCollection;

class PropertyController extends Controller
{
    /**
     * @var MyPropertyCollection
     */
    private MyPropertyCollection $propertyCollection;

    /**
     * @var MyPropertyResource
     */
    private MyPropertyResource $propertyResource;

    /**
     * @var MyNoDataResource
     */
    private MyNoDataResource $noDataResource;

    /**
     * @var MyPropertyRepository
     */
    private MyPropertyRepository $propertyRepository;

    /**
     * PropertyController constructor.
     * @param MyPropertyCollection $propertyCollection
     * @param PropertyResource $propertyResource
     * @param MyNoDataResource $noDataResource
     * @param MyPropertyRepository $propertyRepository
     */
    public function __construct(
        MyPropertyCollection $propertyCollection,
        MyPropertyResource $propertyResource,
        MyNoDataResource $noDataResource,
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
    public function index(): PropertyCollection
    {
        $properties = $this->propertyRepository->all();

        return $this->propertyCollection::make($properties);
    }

    /**
     * @param MyPropertyRequest $request
     * @return PropertyResource
     */
    public function store(MyPropertyRequest $request): PropertyResource
    {
        $properties = $this->propertyRepository->save($request->all());

        return $this->propertyResource::make($properties);
    }

    /**
     * @param int $id
     * @return PropertyResource
     */
    public function show(int $id): PropertyResource
    {
        $property = $this->propertyRepository->findOrFail($id);

        return $this->propertyResource::make($property);
    }

    /**
     * @param MyPropertyRequest $request
     * @param int $id
     * @return PropertyResource
     */
    public function update(MyPropertyRequest $request, int $id): PropertyResource
    {
        $property = $this->propertyRepository->update($id, $request->all());

        return $this->propertyResource::make($property);
    }

    /**
     * @param MyPropertyPurchasedRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function updatePurchased(MyPropertyPurchasedRequest $request, int $id): JsonResponse
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
