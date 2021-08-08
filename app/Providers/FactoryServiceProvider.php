<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\UserService\Interfaces\UserFactoryInterface;
use App\Services\UserService\UserFactory;
use Illuminate\Support\ServiceProvider;

final class FactoryServiceProvider extends ServiceProvider
{
    /**
     * Register the application factories as services.
     */
    public function register(): void
    {
        $factories = [
            UserFactoryInterface::class => UserFactory::class,
        ];

        foreach ($factories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
