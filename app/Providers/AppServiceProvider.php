<?php

namespace App\Providers;

use Illuminate\Support\MessageBag;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        // Create a new MessageBag instance.
        $messageBag = new MessageBag;

        config(['kernel.messageBag' => $messageBag]);
    }
}
