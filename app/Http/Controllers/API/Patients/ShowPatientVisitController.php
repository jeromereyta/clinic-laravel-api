<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\Patients\PatientResource;
use App\Http\Resources\Patients\PatientVisitResource;
use App\Http\Resources\Patients\PatientVisitsResource;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class ShowPatientVisitController extends AbstractAPIController
{
    private PatientVisitRepositoryInterface $patientVisitRepository;

    public function __construct(PatientVisitRepositoryInterface $patientVisitRepository) {
        $this->patientVisitRepository = $patientVisitRepository;
    }

    public function __invoke(int $patientVisitId): JsonResource
    {
        try {
            $patientVisit = $this->patientVisitRepository->findByPatientVisit($patientVisitId);
        } catch (Throwable $exception) {
            dd($exception);
        }

        if ($patientVisit === null) {
            return $this->respondNotFound([
                'message' => 'Patient Visit not found',
            ]);
        }

        return new PatientVisitResource($patientVisit);
    }
}
