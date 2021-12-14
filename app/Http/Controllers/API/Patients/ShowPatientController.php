<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\Patients\PatientResource;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ShowPatientController extends AbstractAPIController
{
    private PatientRepositoryInterface $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function __invoke(string $patientCode): JsonResource
    {
        try {
            $patient = $this->patientRepository->findByPatientCode($patientCode);

            return new PatientResource($patient);
        } catch (Throwable $exception) {
            return $this->respondError(
                'Patient not found',
                Response::HTTP_NOT_FOUND
            );
        }


    }
}
