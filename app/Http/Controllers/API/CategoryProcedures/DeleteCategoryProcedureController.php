<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\CategoryProcedures;

use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\CategoryProcedureRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class DeleteCategoryProcedureController extends AbstractAPIController
{
    private CategoryProcedureRepositoryInterface $categoryProcedureRepository;

    public function __construct(CategoryProcedureRepositoryInterface $categoryProcedureRepository) {
        $this->categoryProcedureRepository = $categoryProcedureRepository;
    }

    public function __invoke(int $categoryProcedureId): JsonResource
    {
        try {
            $categoryProcedure = $this->categoryProcedureRepository->findById($categoryProcedureId);

            if ($categoryProcedure !== null) {
                $this->categoryProcedureRepository->deleteCategoryProcedure($categoryProcedure);
            }

            return $this->respondNoContent();
        } catch (Throwable $throwable) {
            return $this->respondUnprocessable([
                'message' => $throwable->getMessage(),
            ]);
        }
    }
}
