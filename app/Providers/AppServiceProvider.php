<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Type_products;
use App\Cart;
use Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('header',function($view)
        {
            $loai_sp = Type_products::all();
            $view->with('loai_sp',$loai_sp);
        });

        view()->composer(['header','page.thanhtoan'],function($view)
        {
            if(Session('cart'))
            {
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $view->with(['cart'=>Session::get('cart'),'product_cart'=>$cart->items,'totalPrice'=>$cart->totalPrice,'totalQty'=>$cart->totalQty]);
            }
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
