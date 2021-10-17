<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Doctrine\ORM\PatientRepository;
use App\Repositories\Doctrine\ORM\PatientVisitRepository;
use App\Repositories\Doctrine\ORM\UserGuestRepository;
use App\Repositories\Doctrine\ORM\UserRepository;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Repositories\Interfaces\UserGuestRepositoryInterface;
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
            PatientRepositoryInterface::class => PatientRepository::class,
            PatientVisitRepositoryInterface::class => PatientVisitRepository::class,
            UserGuestRepositoryInterface::class => UserGuestRepository::class,
            UserRepositoryInterface::class => UserRepository::class,
        ];

        foreach ($repositories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
