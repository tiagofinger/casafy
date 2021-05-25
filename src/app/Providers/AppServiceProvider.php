<?php

namespace App\Providers;

use App\Http\Requests\PropertyPurchasedRequest;
use App\Http\Requests\PropertyRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\NoDataResource;
use App\Http\Resources\PropertyCollection;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserWithPropertiesResource;
use App\Models\Property;
use App\Models\User;
use App\MyLibrary\Interfaces\MyNoDataResource;
use App\MyLibrary\Interfaces\MyPropertyCollection;
use App\MyLibrary\Interfaces\MyPropertyModel;
use App\MyLibrary\Interfaces\MyPropertyPurchasedRequest;
use App\MyLibrary\Interfaces\MyPropertyRepository;
use App\MyLibrary\Interfaces\MyPropertyRequest;
use App\MyLibrary\Interfaces\MyPropertyResource;
use App\MyLibrary\Interfaces\MyUserCollection;
use App\MyLibrary\Interfaces\MyUserModel;
use App\MyLibrary\Interfaces\MyUserRepository;
use App\MyLibrary\Interfaces\MyUserRequest;
use App\MyLibrary\Interfaces\MyUserResource;
use App\MyLibrary\Interfaces\MyUserWithPropertiesResource;
use App\MyLibrary\Repositories\PropertyRepository;
use App\MyLibrary\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MyPropertyRepository::class, PropertyRepository::class);
        $this->app->bind(MyPropertyModel::class, Property::class);

        $this->app->bind(MyUserRepository::class, UserRepository::class);
        $this->app->bind(MyUserModel::class, User::class);

        $this->app->bind(MyUserRequest::class, UserRequest::class);
        $this->app->bind(MyPropertyRequest::class, PropertyRequest::class);
        $this->app->bind(MyPropertyPurchasedRequest::class, PropertyPurchasedRequest::class);

        $this->app->bind(MyUserCollection::class, UserCollection::class);
        $this->app->bind(MyUserResource::class, UserResource::class);
        $this->app->bind(MyUserWithPropertiesResource::class, UserWithPropertiesResource::class);

        $this->app->bind(MyNoDataResource::class, NoDataResource::class);

        $this->app->bind(MyPropertyCollection::class, PropertyCollection::class);
        $this->app->bind(MyPropertyResource::class, PropertyResource::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
