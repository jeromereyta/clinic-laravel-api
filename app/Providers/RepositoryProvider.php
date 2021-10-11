<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Doctrine\ORM\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

final class RepositoryProvider extends ServiceProvider
{
    /**
     * Register the application factories as services.
     */
    public function register(): void
    {
        $repositories = [
            UserRepositoryInterface::class => UserRepository::class,
        ];

        foreach ($repositories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
