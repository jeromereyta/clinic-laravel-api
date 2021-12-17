<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Queue;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\Queue\ProcedureQueuesResource;
use App\Repositories\Interfaces\ProcedureQueueRepositoryInterface;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

final class ListProcedureQueueController extends AbstractAPIController
{
    public const CACHE_KEY = 'procedures';
    private ProcedureQueueRepositoryInterface $procedureQueueRepository;

    public function __construct(ProcedureQueueRepositoryInterface $procedureQueueRepository) {
        $this->procedureQueueRepository = $procedureQueueRepository;
    }

    public function __invoke(Request $request): JsonResource
    {
        $procedureQueues = $this->procedureQueueRepository->findWithQueues();

        return new ProcedureQueuesResource($procedureQueues);
    }
}
