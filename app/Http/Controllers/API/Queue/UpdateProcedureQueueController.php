<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Queue;

use App\Enum\ProcedureQueueTypeEnum;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Queue\UpdateProcedureQueueRequest;
use App\Http\Resources\Queue\ProcedureQueuesResource;
use App\Repositories\Interfaces\ProcedureQueueRepositoryInterface;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class UpdateProcedureQueueController extends AbstractAPIController
{
    private ProcedureQueueRepositoryInterface $procedureQueueRepository;

    public function __construct(ProcedureQueueRepositoryInterface $procedureQueueRepository) {
        $this->procedureQueueRepository = $procedureQueueRepository;
    }

    public function __invoke(UpdateProcedureQueueRequest $request): JsonResource
    {
        $procedureQueue = null;

        try {
                $procedureQueue = $this->procedureQueueRepository->findById($request->getId());

                if ($request->isToMoveBack() === true) {
                    $nextQueues = $this->procedureQueueRepository->findNextProcedureQueue(
                        $procedureQueue->getPatientProcedure()->getProcedure(),
                        $procedureQueue->getQueueNumber()
                    );

                    if (\count($nextQueues) === 0) {
                        return $this->respondNoContent();
                    }

                    $nextQueue = $this->procedureQueueRepository->findById($nextQueues[0]['id']);

                    $temporaryQueueNumber = $procedureQueue->getQueueNumber();

                    $this->procedureQueueRepository->updateQueueNumber($procedureQueue, $nextQueue->getQueueNumber());

                    $this->procedureQueueRepository->updateQueueNumber($nextQueue, $temporaryQueueNumber);

                    return $this->respondNoContent();
                }
        } catch (NoResultException $notFoundException) {
            $this->respondNotFound([
                'message' => $notFoundException->getMessage(),
            ]);
        } catch (NonUniqueResultException | Throwable $exception) {
            return $this->respondUnprocessable([
                'message' => $exception->getMessage(),
            ]);
        }

        if ($procedureQueue === null) {
            return $this->respondNoContent();
        }

        try {
            $this->procedureQueueRepository->updateStatus($procedureQueue, new ProcedureQueueTypeEnum($request->getStatus()));
        } catch (ORMException|OptimisticLockException $exception) {
            return $this->respondUnprocessable([
                'message' => $exception->getMessage(),
            ]);
        }

        return $this->respondNoContent();
    }
}
