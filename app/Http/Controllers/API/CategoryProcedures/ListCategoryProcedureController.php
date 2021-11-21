<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\CategoryProcedures;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\CategoryProcedures\CategoryProceduresResource;
use App\Repositories\Interfaces\CategoryProcedureRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListCategoryProcedureController extends AbstractAPIController
{
    private CategoryProcedureRepositoryInterface $categoryProcedureRepository;

    public function __construct(CategoryProcedureRepositoryInterface $categoryProcedureRepository) {
        $this->categoryProcedureRepository = $categoryProcedureRepository;
    }

    public function __invoke(Request $request): JsonResource
    {
        return new CategoryProceduresResource(
            $this->categoryProcedureRepository->all()
        );
    }
}
