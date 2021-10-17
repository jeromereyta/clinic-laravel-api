<?php

declare(strict_types=1);

namespace App\Services\PatientService\Interfaces;

interface GeneratePatientCodeServiceInterface
{
    public function generate(string $latestId): string;
}
