<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Type_products;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('header',function($view){
            $loai_sp = Type_products::all();
            $view->with('loai_sp',$loai_sp);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
