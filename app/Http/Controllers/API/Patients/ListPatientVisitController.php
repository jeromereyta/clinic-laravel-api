<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\Patients\AllPatientVisitsResource;
use App\Http\Resources\Patients\PatientsResource;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Repositories\Interfaces\ProcedureQueueRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListPatientVisitController extends AbstractAPIController
{
    private PatientVisitRepositoryInterface $patientVisitRepository;

    private ProcedureQueueRepositoryInterface $procedureQueueRepository;

    public function __construct(
        ProcedureQueueRepositoryInterface $procedureQueueRepository,
        PatientVisitRepositoryInterface $patientVisitRepository
    ) {
        $this->patientVisitRepository = $patientVisitRepository;
        $this->procedureQueueRepository = $procedureQueueRepository;
    }

    public function __invoke(Request $request): JsonResource
    {
        $patients = $this->patientVisitRepository->allWithPatientVisits();

        if (\count($patients) === 0) {
            $this->procedureQueueRepository->deleteAll();
        }

        return new AllPatientVisitsResource($patients);
    }
}
