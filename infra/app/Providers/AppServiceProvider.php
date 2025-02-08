<?php

namespace App\Providers;

use App\Repositories\Eloquent\UserRepository;
use Domain\User\Repositories\IUserRepository;
use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindRepositories();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function bindRepositories(): void
    {
        $this->app->singleton(
            IUserRepository::class,
            UserRepository::class
        );
    }
}
