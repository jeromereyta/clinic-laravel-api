<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Procedures;

use App\Database\Entities\Procedure;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Procedures\UpdateProcedureRequest;
use App\Http\Resources\Procedures\ProcedureResource;
use App\Repositories\Interfaces\CategoryProcedureRepositoryInterface;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use App\Services\Procedure\Resources\CreateProcedureResource;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\ORMException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UpdateProcedureController extends AbstractAPIController
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

    public function __invoke(int $procedureId, UpdateProcedureRequest $request): JsonResource
    {
        $procedure = $this->getProcedure($procedureId);

        if ($procedure === null) {
            return $this->respondError('Procedure not found.', Response::HTTP_NOT_FOUND);
        }

        $existingNames = [];

        if ($procedure->getName() !== $request->getName()) {
            $existingNames = $this->procedureRepository->findByName($request->getName());
        }

        if (\count($existingNames) > 0) {
            return $this->respondError('Existing name.');
        }

        try {
            $categoryProcedure = $this->categoryProcedureRepository->findById($request->getCategoryProcedureId());
        } catch (NoResultException | NonUniqueResultException $ormException) {
            return $this->respondError('Invalid Category Procedure.');
        }

        try {
            $procedure = $this->procedureRepository->updateProcedure(
                $procedure,
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

    public function getProcedure(int $procedureId): ?Procedure{
        try {
            return $this->procedureRepository->findById($procedureId);
        } catch (NoResultException | NonUniqueResultException | Throwable $ormException) {
            return null;
        }
    }
}
