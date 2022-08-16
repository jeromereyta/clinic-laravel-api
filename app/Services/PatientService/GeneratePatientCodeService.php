<?php

declare(strict_types=1);

namespace App\Services\PatientService;

use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Services\PatientService\Interfaces\GeneratePatientCodeServiceInterface;

final class GeneratePatientCodeService implements GeneratePatientCodeServiceInterface
{
    public function generate(string $latestId): string
    {
        $id = (int) $latestId;
        $id++;

        return \str_pad((string) $id,6,"0",STR_PAD_LEFT);
    }
}
