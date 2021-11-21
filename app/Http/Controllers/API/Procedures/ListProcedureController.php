<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Procedures;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\Procedures\ProceduresResource;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListProcedureController extends AbstractAPIController
{
    private ProcedureRepositoryInterface $procedureRepository;

    public function __construct(ProcedureRepositoryInterface $procedureRepository) {
        $this->procedureRepository = $procedureRepository;
    }

    public function __invoke(Request $request): JsonResource
    {
        return new ProceduresResource(
            $this->procedureRepository->all()
        );
    }
}
