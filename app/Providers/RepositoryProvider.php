<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Doctrine\ORM\CategoryProcedureRepository;
use App\Repositories\Doctrine\ORM\FileTypeRepository;
use App\Repositories\Doctrine\ORM\FileUploadRepository;
use App\Repositories\Doctrine\ORM\PatientProcedureRepository;
use App\Repositories\Doctrine\ORM\PatientRepository;
use App\Repositories\Doctrine\ORM\PatientVisitRepository;
use App\Repositories\Doctrine\ORM\ProcedureQueueRepository;
use App\Repositories\Doctrine\ORM\ProcedureRepository;
use App\Repositories\Doctrine\ORM\UserGuestRepository;
use App\Repositories\Doctrine\ORM\UserRepository;
use App\Repositories\Interfaces\CategoryProcedureRepositoryInterface;
use App\Repositories\Interfaces\FileTypeRepositoryInterface;
use App\Repositories\Interfaces\FileUploadRepositoryInterface;
use App\Repositories\Interfaces\PatientProcedureRepositoryInterface;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Repositories\Interfaces\ProcedureQueueRepositoryInterface;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
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
            CategoryProcedureRepositoryInterface::class => CategoryProcedureRepository::class,
            FileTypeRepositoryInterface::class => FileTypeRepository::class,
            FileUploadRepositoryInterface::class => FileUploadRepository::class,
            PatientProcedureRepositoryInterface::class => PatientProcedureRepository::class,
            PatientRepositoryInterface::class => PatientRepository::class,
            PatientVisitRepositoryInterface::class => PatientVisitRepository::class,
            ProcedureRepositoryInterface::class => ProcedureRepository::class,
            ProcedureQueueRepositoryInterface::class => ProcedureQueueRepository::class,
            UserGuestRepositoryInterface::class => UserGuestRepository::class,
            UserRepositoryInterface::class => UserRepository::class,
        ];

        foreach ($repositories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
