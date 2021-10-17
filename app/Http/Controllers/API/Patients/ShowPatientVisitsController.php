<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\Patients\PatientResource;
use App\Http\Resources\Patients\PatientVisitsResource;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ShowPatientVisitsController extends AbstractAPIController
{
    private PatientRepositoryInterface $patientRepository;

    private PatientVisitRepositoryInterface $patientVisitRepository;

    public function __construct(
        PatientRepositoryInterface $patientRepository,
        PatientVisitRepositoryInterface $patientVisitRepository
    ) {
        $this->patientRepository = $patientRepository;
        $this->patientVisitRepository = $patientVisitRepository;
    }

    public function __invoke(string $patientCode): JsonResource
    {
        $patient = $this->patientRepository->findByPatientCode($patientCode);

        if ($patient === null) {
            return $this->respondNotFound([
                'message' => 'Patient not found',
            ]);
        }

        $patientVisits = $this->patientVisitRepository->findByPatient($patient);

        return new PatientVisitsResource($patientVisits);
    }
}
