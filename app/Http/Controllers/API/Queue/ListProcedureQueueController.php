<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Queue;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\Queue\ProcedureQueuesResource;
use App\Repositories\Interfaces\ProcedureQueueRepositoryInterface;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListProcedureQueueController extends AbstractAPIController
{
    private ProcedureQueueRepositoryInterface $procedureQueueRepository;

    public function __construct(ProcedureQueueRepositoryInterface $procedureQueueRepository) {
        $this->procedureQueueRepository = $procedureQueueRepository;
    }

    public function __invoke(Request $request): JsonResource
    {
        $result = $this->procedureQueueRepository->findWithQueues();

        return new ProcedureQueuesResource($result);
    }
}
