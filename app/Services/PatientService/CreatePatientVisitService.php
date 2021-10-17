<?php

declare(strict_types=1);

namespace App\Services\PatientService;

use App\Database\Entities\PatientVisit;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Services\PatientService\Interfaces\CreatePatientVisitServiceInterface;
use App\Services\PatientService\Resources\CreatePatientVisitResource;

final class CreatePatientVisitService implements CreatePatientVisitServiceInterface
{

    /**
     * @var \App\Repositories\Interfaces\PatientVisitRepositoryInterface
     */
    private PatientVisitRepositoryInterface $patientVisitRepository;

    public function __construct(PatientVisitRepositoryInterface $patientVisitRepository)
    {
        $this->patientVisitRepository = $patientVisitRepository;
    }

    public function create(CreatePatientVisitResource $resource): PatientVisit
    {
        return $this->patientVisitRepository->create($resource);
    }
}
