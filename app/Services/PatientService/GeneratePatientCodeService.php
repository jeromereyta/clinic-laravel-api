<?php

declare(strict_types=1);

namespace App\Services\PatientService;

use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Services\PatientService\Interfaces\GeneratePatientCodeServiceInterface;

final class GeneratePatientCodeService implements GeneratePatientCodeServiceInterface
{
    /**
     * @var string
     */
    public const KEY_FORMAT = '%s%s';

    public function generate(string $latestId): string
    {
        return \str_pad($latestId,8,"0",STR_PAD_LEFT);
    }
}
