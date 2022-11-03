<?php

namespace App\Providers;

use App\Repositories\BookRepository;
use App\Services\BookService;
use App\Services\Contracts\IBookService;
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
        $this->app->bind(IBookService::class, function ($app) {
            return new BookService($app->make(BookRepository::class));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
