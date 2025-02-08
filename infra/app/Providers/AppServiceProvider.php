<?php

namespace App\Providers;

use App\Repositories\Eloquent\UserRepository;
use Domain\User\Repositories\IUserRepository;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use app\Exceptions\Handler as CustomException;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindRepositories();
        $this->bindException();
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

    private function bindException(): void
    {
        $this->app->singleton(
            ExceptionHandler::class,
            CustomException::class
        );
    }
}
