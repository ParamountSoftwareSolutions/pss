<?php

namespace App\Providers;

use App\Models\AdminPermission;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*',function($view) {
            $view->with('permissions', AdminPermission::first()); 
        });
        Paginator::useBootstrap();
    }
}
