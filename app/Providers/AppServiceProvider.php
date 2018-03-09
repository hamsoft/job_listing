<?php

namespace JobListing\Providers;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use JobListing\Contracts\CurrentCompany;
use JobListing\Contracts\CurrentUser;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Guard $guard) {

        Schema::defaultStringLength(191);

        $this->app->singleton(CurrentUser::class, function () use ($guard) {
            return $guard->user();
        });

        $this->app->singleton(CurrentCompany::class, function () {
            $user = $this->app->make(CurrentUser::class);
            return $user->getCompany();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
