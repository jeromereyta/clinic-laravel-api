<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Database\Entities\User;
use App\Enum\ProcedureQueueTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Patients\CreateTransactionSummaryRequest;
use App\Repositories\Interfaces\PatientProcedureRepositoryInterface;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Repositories\Interfaces\ProcedureQueueRepositoryInterface;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use App\Repositories\Interfaces\TransactionSummaryRepositoryInterface;
use App\Repositories\Interfaces\UserGuestRepositoryInterface;
use App\Services\ProcedureQueue\Resources\CreateProcedureQueueResource;
use App\Services\TransactionSummary\Resources\CreateTransactionSummary;
use Exception;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreateTransactionSummaryController extends AbstractAPIController
{
    private PatientProcedureRepositoryInterface $patientProcedureRepository;

    private PatientVisitRepositoryInterface $patientVisitRepository;

    private ProcedureQueueRepositoryInterface $procedureQueueRepository;

    private TransactionSummaryRepositoryInterface $transactionSummaryRepository;

    private UserGuestRepositoryInterface $userGuestRepository;

    public function __construct(
        PatientProcedureRepositoryInterface $patientProcedureRepository,
        PatientVisitRepositoryInterface $patientVisitRepository,
        ProcedureRepositoryInterface $procedureRepository,
        ProcedureQueueRepositoryInterface $procedureQueueRepository,
        TransactionSummaryRepositoryInterface $transactionSummaryRepository,
        UserGuestRepositoryInterface $userGuestRepository
    ) {
        $this->patientProcedureRepository = $patientProcedureRepository;
        $this->patientVisitRepository = $patientVisitRepository;
        $this->procedureQueueRepository = $procedureQueueRepository;
        $this->transactionSummaryRepository = $transactionSummaryRepository;
        $this->userGuestRepository = $userGuestRepository;
    }

    public function __invoke(CreateTransactionSummaryRequest $request): JsonResource
    {
        $user = $this->getUser();

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

        try {
            $latestCountToday = $this->transactionSummaryRepository->findLatestTransactionCountToday();

            if ($latestCountToday === "" || $latestCountToday === null) {
                $latestCountToday = "01";
            } else {
                $latestCountToday = (int) $latestCountToday + 1;

                if (strlen((string)$latestCountToday) === 1) {
                    $latestCountToday = sprintf('0%s', $latestCountToday);
                }
            }

             $this->transactionSummaryRepository->create(new CreateTransactionSummary([
                 'transactionCountThisDay' => $latestCountToday,
                 'paymentMethod' => $request->getPaymentMethod(),
                 'patientVisit' => $patientVisit,
                 'createdBy' => $userGuest,
                 'remarks' => $request->getRemarks(),
                 'totalAmount' => $request->getTotalAmount(),
            ]));
        } catch (Exception $exception) {
            return $this->respondUnprocessable([
                'message' => $exception->getMessage(),
            ]);
        }

        // Once transaction summary is submitted will send it to queue
        $patientProcedures = $this->patientProcedureRepository->findByPatientVisit($patientVisit);

        $latestQueue = $this->procedureQueueRepository->findLatestQueueNumber();
        $latestQueue = $latestQueue === 0 ? 1 : $latestQueue;

        $queueNumber = ++$latestQueue;

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
