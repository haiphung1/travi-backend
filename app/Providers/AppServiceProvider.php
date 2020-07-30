<?php

namespace App\Providers;

use App\Interfaces\FriendInterface;
use App\Interfaces\PostInterface;
use App\Interfaces\TravelGroupInterface;
use App\Interfaces\UserGroupInterface;
use App\Services\FriendService;
use App\Services\PostService;
use App\Services\TravelGroupService;
use App\Services\UserGroupService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(UserGroupInterface::class, UserGroupService::class);
        $this->app->singleton(PostInterface::class, PostService::class);
        $this->app->singleton(TravelGroupInterface::class, TravelGroupService::class);
        $this->app->singleton(FriendInterface::class, FriendService::class);
    }
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
