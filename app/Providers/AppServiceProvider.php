<?php

namespace App\Providers;

use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
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


        CreateAction::configureUsing(fn(CreateAction $action) => $action->slideOver());

        EditAction::configureUsing(fn(EditAction $action) => $action->slideOver());
    }
}
