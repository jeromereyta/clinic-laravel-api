<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\CategoryProcedures;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\CategoryProcedures\CreateCategoryProcedureRequest;
use App\Http\Resources\CategoryProcedures\CategoryProcedureResource;
use App\Repositories\Interfaces\CategoryProcedureRepositoryInterface;
use App\Services\CategoryProcedure\Resources\CreateCategoryProcedureResource;
use Doctrine\ORM\ORMException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class CreateCategoryProcedureController extends AbstractAPIController
{
    private CategoryProcedureRepositoryInterface $categoryProcedureRepository;

    public function __construct(CategoryProcedureRepositoryInterface $categoryProcedureRepository) {
        $this->categoryProcedureRepository = $categoryProcedureRepository;
    }

    public function __invoke(CreateCategoryProcedureRequest $request): JsonResource
    {
        try {
            $categoryProcedure = $this->categoryProcedureRepository->create(
                new CreateCategoryProcedureResource([
                    'name' => $request->getName(),
                    'description' => $request->getDescription(),
                    'type' => $request->getType(),
                ])
            );

            return new CategoryProcedureResource($categoryProcedure);
        } catch (ORMException $ormException) {
            return $this->respondUnprocessable([
                'message' => $ormException->getMessage(),
            ]);
        } catch (Throwable $throwable) {
            return $this->respondUnprocessable([
                'message' => $throwable->getMessage(),
            ]);
        }


    }
}
