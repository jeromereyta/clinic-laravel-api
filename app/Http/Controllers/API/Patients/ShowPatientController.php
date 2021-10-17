<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\Patients\PatientResource;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ShowPatientController extends AbstractAPIController
{
    private PatientRepositoryInterface $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function __invoke(string $patientCode): JsonResource
    {
        $patient = $this->patientRepository->findByPatientCode($patientCode);

        if ($patient === null) {
            return $this->respondNotFound([
                'message' => 'Patient not found',
            ]);
        }

        return new PatientResource($patient);
    }
}
