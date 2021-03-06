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
            $list = array_map(function (...$list){
                return $list;
            }, ...$this->values());
            return new static($list);
        });

        Collection::macro('pipeMousab', function ($callback){
            return $callback($this);
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
