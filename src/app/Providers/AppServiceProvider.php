<?php

namespace App\Providers;

use App\Models\Property;
use App\Models\User;
use App\MyLibrary\Interfaces\MyPropertyModel;
use App\MyLibrary\Interfaces\MyPropertyRepository;
use App\MyLibrary\Interfaces\MyUserModel;
use App\MyLibrary\Interfaces\MyUserRepository;
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
