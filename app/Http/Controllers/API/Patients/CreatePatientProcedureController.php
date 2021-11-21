<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Database\Entities\User;
use App\Enum\ProcedureQueueTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Patients\CreatePatientProcedureRequest;
use App\Repositories\Interfaces\PatientProcedureRepositoryInterface;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Repositories\Interfaces\ProcedureQueueRepositoryInterface;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use App\Repositories\Interfaces\UserGuestRepositoryInterface;
use App\Services\PatientService\Resources\CreatePatientProcedureResource;
use App\Services\ProcedureQueue\Resources\CreateProcedureQueueResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreatePatientProcedureController extends AbstractAPIController
{
    private PatientProcedureRepositoryInterface $patientProcedureRepository;

    private PatientVisitRepositoryInterface $patientVisitRepository;

    private ProcedureRepositoryInterface $procedureRepository;

    private ProcedureQueueRepositoryInterface $procedureQueueRepository;

    private UserGuestRepositoryInterface $userGuestRepository;

    public function __construct(
        PatientProcedureRepositoryInterface $patientProcedureRepository,
        PatientVisitRepositoryInterface $patientVisitRepository,
        ProcedureRepositoryInterface $procedureRepository,
        ProcedureQueueRepositoryInterface $procedureQueueRepository,
        UserGuestRepositoryInterface $userGuestRepository
    ) {
        $this->patientProcedureRepository = $patientProcedureRepository;
        $this->patientVisitRepository = $patientVisitRepository;
        $this->procedureQueueRepository = $procedureQueueRepository;
        $this->procedureRepository = $procedureRepository;
        $this->userGuestRepository = $userGuestRepository;
    }

    public function __invoke(CreatePatientProcedureRequest $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user === null) {
            return $this->respondForbidden();
        }

        $userGuest = $this->userGuestRepository->findByUser($user);

        if ($userGuest === null) {
            return $this->respondUnprocessable([
                'message' => 'User not found',
            ]);
        }

        $patientVisit = $this->patientVisitRepository->findByPatientVisit($request->getPatientVisitId());

        if ($patientVisit === null) {
            return $this->respondNotFound([
                'message' => 'Patient visit not found',
            ]);
        }

        $countOfIds = \count($request->getProcedureIds());

        if ($countOfIds === 0) {
            return $this->respondUnprocessable([
                'message' => 'Procedure not found',
            ]);
        }

        $procedures = $this->procedureRepository->findByProcedureIds($request->getProcedureIds());

        if (\count($procedures) !== $countOfIds) {
            return $this->respondNotFound([
                'message' => 'Invalid Procedures, please verify each id or contact System Administrator',
            ]);
        }


        $patientProcedures = $this->patientProcedureRepository->createPatientProcedures(new CreatePatientProcedureResource([
            'createdBy' => $userGuest,
            'procedures' => $procedures,
            'patientVisit' => $patientVisit,
        ]));

        $latestQueue = $this->procedureQueueRepository->findLatestQueueNumber() ?? 1;

        $queueNumber = $latestQueue++;

        foreach ($patientProcedures as $patientProcedure) {

            $this->procedureQueueRepository->create(new CreateProcedureQueueResource([
                'patientProcedure' => $patientProcedure,
                'createdBy' => $userGuest,
                'status' => new ProcedureQueueTypeEnum(ProcedureQueueTypeEnum::IN_QUEUE),
                'queueNumber' => $queueNumber,
            ]));

            $queueNumber = $latestQueue++;
        }

        return $this->respondNoContent();
    }
}