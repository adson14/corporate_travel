<?php

namespace App\Providers;

use App\Models\User;
use App\Observers\UserObserver;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Presenters\PaginationPresenter;
use App\Services\AuthService;
use Application\Contract\IAuthService;
use Domain\Order\Repositories\IOrderRepository;
use Domain\Share\Repositories\IPagination;
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
        User::observe(UserObserver::class);
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

        $this->app->bind(
            IPagination::class,
            PaginationPresenter::class
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
