<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\PatientService\GeneratePatientCodeService;
use App\Services\PatientService\Interfaces\GeneratePatientCodeServiceInterface;
use Illuminate\Support\ServiceProvider;

final class PatientServiceProvider extends ServiceProvider
{
    /**
     * Register the application factories as services.
     */
    public function register(): void
    {
        $factories = [
            GeneratePatientCodeServiceInterface::class => GeneratePatientCodeService::class,
        ];

        foreach ($factories as $abstract => $concrete) {
            $this->app->bind($abstract, $concrete);
        }
    }
}
