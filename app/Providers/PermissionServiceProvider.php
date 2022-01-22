<?php

namespace App\Providers;

use App\Facades\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;


class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register() {}

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {}
}
