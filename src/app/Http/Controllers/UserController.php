<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserWithPropertiesResource;
use App\Http\Resources\UserCollection;
use App\MyLibrary\Interfaces\MyNoDataResource;
use App\MyLibrary\Interfaces\MyUserCollection;
use App\MyLibrary\Interfaces\MyUserRepository;
use App\MyLibrary\Interfaces\MyUserResource;
use App\MyLibrary\Interfaces\MyUserWithPropertiesResource;
use Illuminate\Http\JsonResponse;
use App\MyLibrary\Interfaces\MyUserRequest;

class UserController extends Controller
{
    /**
     * @var MyUserCollection
     */
    private MyUserCollection $userCollection;

    /**
     * @var MyUserResource
     */
    private MyUserResource $userResource;

    /**
     * @var MyNoDataResource
     */
    private MyNoDataResource $noDataResource;

    /**
     * @var MyUserRepository
     */
    private MyUserRepository $userRepository;

    /**
     * @var MyUserWithPropertiesResource
     */
    private $userWithPropertiesResource;

    /**
     * UserController constructor.
     * @param MyUserCollection $userCollection
     * @param MyUserResource $userResource
     * @param MyUserWithPropertiesResource $userWithPropertyResource
     * @param MyNoDataResource $noDataResource
     * @param MyUserRepository $userRepository
     */
    public function __construct(
        MyUserCollection $userCollection,
        MyUserResource $userResource,
        MyUserWithPropertiesResource $UserWithPropertiesResource,
        MyNoDataResource $noDataResource,
        MyUserRepository $userRepository
    ) {
        $this->userCollection = $userCollection;
        $this->userResource = $userResource;
        $this->userWithPropertiesResource = $UserWithPropertiesResource;
        $this->noDataResource = $noDataResource;
        $this->userRepository = $userRepository;
    }

    /**
     * @return UserCollection
     */
    public function index(): UserCollection
    {
        $users = $this->userRepository->all();

        return $this->userCollection::make($users);
    }

    /**
     * @param UserRequest $request
     * @return UserResource
     */
    public function store(MyUserRequest $request): UserResource
    {
        $user = $this->userRepository->save($request->all());

        return $this->userResource::make($user);
    }

    /**
     * @param int $id
     * @return UserResource
     */
    public function show(int $id): UserResource
    {
        $user = $this->userRepository->findOrFail($id);

        return $this->userResource::make($user);
    }

    /**
     * @param MyUserRequest $request
     * @param int $id
     * @return UserResource
     */
    public function update(MyUserRequest $request, int $id): UserResource
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
     * @return UserWithPropertiesResource
     */
    public function properties(int $id): UserWithPropertiesResource
    {
        $properties = $this->userRepository->properties($id);

        return $this->userWithPropertiesResource::make($properties);
    }
}
