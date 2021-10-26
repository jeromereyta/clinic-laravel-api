<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Procedures;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Procedures\CreateProcedureRequest;
use App\Http\Resources\Procedures\ProcedureResource;
use App\Repositories\Interfaces\CategoryProcedureRepositoryInterface;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use App\Services\Procedure\Resources\CreateProcedureResource;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\ORMException;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class CreateProcedureController extends AbstractAPIController
{
    private ProcedureRepositoryInterface $procedureRepository;

    private CategoryProcedureRepositoryInterface $categoryProcedureRepository;

    public function __construct(
        CategoryProcedureRepositoryInterface $categoryProcedureRepository,
        ProcedureRepositoryInterface $procedureRepository
    ) {
        $this->categoryProcedureRepository = $categoryProcedureRepository;
        $this->procedureRepository = $procedureRepository;
    }

    public function __invoke(CreateProcedureRequest $request): JsonResource
    {
        try {
            $categoryProcedure = $this->categoryProcedureRepository->findById($request->getCategoryProcedureId());
        } catch (NoResultException | NonUniqueResultException $ormException) {
            return $this->respondBadRequest([
                'message' => 'Invalid Category Procedure.',
            ]);
        }

        try {
            $procedure = $this->procedureRepository->create(
                new CreateProcedureResource([
                    'active' => $request->isActive(),
                    'categoryProcedure' => $categoryProcedure,
                    'description' => $request->getDescription(),
                    'name' => $request->getName(),
                    'price' => $request->getPrice(),
                ])
            );

            return new ProcedureResource($procedure);
        } catch (ORMException $ormException) {
            return $this->respondUnprocessable([
                'message' => $ormException->getMessage(),
            ]);
        } catch (Throwable $throwable) {
            return $this->respondInternalError([
                'message' => $throwable->getMessage(),
            ]);
        }
    }
}
