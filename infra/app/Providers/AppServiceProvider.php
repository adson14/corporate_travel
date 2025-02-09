<?php

namespace App\Providers;

use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Services\AuthService;
use Application\Contract\IAuthService;
use Domain\Order\Repositories\IOrderRepository;
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
        $this->bindServices();
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

        $this->app->bind(
            IOrderRepository::class,
            OrderRepository::class
        );
    }

    private function bindServices(): void
    {
        $this->app->bind(
            IAuthService::class,
            AuthService::class
        );
    }
}
