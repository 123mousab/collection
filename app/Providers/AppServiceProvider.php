<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
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
        Collection::macro('toAssoc',function (){
            return $this->reduce(function ($assoc, $keyAndValue){
                list($key, $value) = $keyAndValue;
                $assoc[$key] = $value;
                return $assoc;
            }, new static);
        });

        Collection::macro('transpose',function (){
            $items = array_map(function (...$items){
                return $items;
            }, ...$this->values());
            return new static($items);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(199);
    }
}
