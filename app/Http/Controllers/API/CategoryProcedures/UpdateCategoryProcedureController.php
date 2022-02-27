<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\CategoryProcedures;

use App\Database\Entities\CategoryProcedure;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\CategoryProcedures\UpdateCategoryProcedureRequest;
use App\Http\Resources\CategoryProcedures\CategoryProcedureResource;
use App\Repositories\Interfaces\CategoryProcedureRepositoryInterface;
use App\Services\CategoryProcedure\Resources\CreateCategoryProcedureResource;
use Doctrine\ORM\NoResultException;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class UpdateCategoryProcedureController extends AbstractAPIController
{
    private CategoryProcedureRepositoryInterface $categoryProcedureRepository;

    public function __construct(CategoryProcedureRepositoryInterface $categoryProcedureRepository) {
        $this->categoryProcedureRepository = $categoryProcedureRepository;
    }

    public function __invoke(int $categoryProcedureId, UpdateCategoryProcedureRequest $request): JsonResource
    {
        $categoryProcedure = $this->getCategoryProcedure($categoryProcedureId);

        if ($categoryProcedure === null) {
            return $this->respondError('Category procedure not found', Response::HTTP_NOT_FOUND);
        }

        try {
            $existingNames = [];

            if ($categoryProcedure->getName() !== $request->getName()) {
                $existingNames = $this->categoryProcedureRepository->findByName($request->getName());
            }

            if (\count($existingNames) > 0) {
                return $this->respondError('Existing name.');
            }

            $resource = new CreateCategoryProcedureResource([
                'name' => $request->getName() ?? $categoryProcedure->getName(),
                'description' => $request->getDescription() ?? $categoryProcedure->getDescription(),
                'type' => $request->getType() ?? $categoryProcedure->getType(),
            ]);

            $categoryProcedure = $this->categoryProcedureRepository->updateCategoryProcedure(
                $categoryProcedure,
                $resource
            );

            return new CategoryProcedureResource($categoryProcedure);
        } catch (Throwable $throwable) {
            return $this->respondUnprocessable([
                'message' => $throwable->getMessage(),
            ]);
        }
    }

    public function getCategoryProcedure(int $categoryProcedureId): ?CategoryProcedure
    {
        try {
            return $this->categoryProcedureRepository->findById($categoryProcedureId);
        } catch (Throwable $exception) {
            return null;
        }
    }
}
