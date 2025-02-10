<?php

namespace App\Providers;

use App\Event\EventDispatcher;
use App\Models\User;
use App\Observers\UserObserver;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Presenters\PaginationPresenter;
use App\Services\AuthService;
use App\Services\NotificationService;
use Application\Contract\IAuthService;
use Application\Contract\IEventDispatcher;
use Application\Contract\INotificationService;
use Application\Handlers\ApproveOrderEventHandler;
use Domain\Events\OrderApproveEvent;
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

        $this->app->singleton(IEventDispatcher::class, function () {
            return new EventDispatcher();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(IEventDispatcher $dispatcher): void
    {
        User::observe(UserObserver::class);

        $dispatcher->registerHandlers(
            OrderApproveEvent::class,
            [new ApproveOrderEventHandler($this->app->make(INotificationService::class)), 'handle']
        );
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

        $this->app->bind(
            INotificationService::class,
            NotificationService::class
        );

    }
}
