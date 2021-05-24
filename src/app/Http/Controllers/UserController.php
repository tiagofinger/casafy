<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoDataResource;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserWithPropertiesResource;
use App\Http\Resources\UserCollection;
use App\MyLibrary\Interfaces\MyCollection;
use App\MyLibrary\Interfaces\MyResource;
use App\MyLibrary\Interfaces\MyUserRepository;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * @var UserCollection
     */
    private UserCollection $userCollection;

    /**
     * @var UserResource
     */
    private UserResource $userResource;

    /**
     * @var NoDataResource
     */
    private NoDataResource $noDataResource;

    /**
     * @var MyUserRepository
     */
    private MyUserRepository $userRepository;

    /**
     * @var UserWithPropertiesResource
     */
    private $userWithPropertiesResource;

    /**
     * UserController constructor.
     * @param UserCollection $userCollection
     * @param UserResource $userResource
     * @param UserWithPropertiesResource $userWithPropertyResource
     * @param NoDataResource $noDataResource
     * @param MyUserRepository $userRepository
     */
    public function __construct(
        UserCollection $userCollection,
        UserResource $userResource,
        UserWithPropertiesResource $UserWithPropertiesResource,
        NoDataResource $noDataResource,
        MyUserRepository $userRepository
    )
    {
        $this->userCollection = $userCollection;
        $this->userResource = $userResource;
        $this->userWithPropertiesResource = $UserWithPropertiesResource;
        $this->noDataResource = $noDataResource;
        $this->userRepository = $userRepository;
    }

    /**
     * @return MyCollection
     */
    public function index(): MyCollection
    {
        $users = $this->userRepository->all();

        return $this->userCollection::make($users);
    }

    /**
     * @param UserRequest $request
     * @return MyResource
     */
    public function store(UserRequest $request): MyResource
    {
        $user = $this->userRepository->save($request->all());

        return $this->userResource::make($user);
    }

    /**
     * @param int $id
     * @return UserResource
     */
    public function show(int $id): MyResource
    {
        $user = $this->userRepository->findOrFail($id);

        return $this->userResource::make($user);
    }

    /**
     * @param UserRequest $request
     * @param int $id
     * @return UserResource
     */
    public function update(UserRequest $request, int $id): MyResource
    {
        $user = $this->userRepository->update($id, $request->all());

        return $this->userResource::make($user);
    }

    /**
     * @param $id
     * @return JsonResponse|object
     */
    public function destroy(int $id): JsonResponse
    {
        $this->userRepository->destroy($id);

        return $this->noDataResource::make()
            ->response()
            ->setStatusCode(204);
    }

    /**
     * @param $id
     * @return JsonResponse|object
     */
    public function properties(int $id): MyResource
    {
        $properties = $this->userRepository->properties($id);

        return $this->userWithPropertiesResource::make($properties);
    }
}
