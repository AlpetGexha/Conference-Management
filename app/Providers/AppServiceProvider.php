<?php

namespace App\Providers;

use Blueprint\Contracts\Model;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        EloquentModel::unguard();
    }
}
