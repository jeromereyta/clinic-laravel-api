<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PackageProcedure;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PackageProcedure\UpdatePackageProcedureRequest;
use App\Http\Requests\API\PackageProcedure\UpdatePackageRequest;
use App\Repositories\Interfaces\PackageProcedureRepositoryInterface;
use App\Repositories\Interfaces\PackageRepositoryInterface;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use App\Services\PackageProcedureService\Resources\CreatePackageProcedureResource;
use App\Services\PackageProcedureService\Resources\CreatePackageResource;
use App\Services\PackageProcedureService\Resources\UpdatePackageProcedureResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

class EditPackageProcedureController extends AbstractAPIController
{
    private PackageProcedureRepositoryInterface $packageProcedureRepository;

    public function __construct(PackageProcedureRepositoryInterface $packageProcedureRepository)
    {
        $this->packageProcedureRepository = $packageProcedureRepository;
     }

    public function __invoke(int $id, UpdatePackageProcedureRequest $request): JsonResource
    {
        try {
            $packageProcedure = $this->packageProcedureRepository->findById($id);
        } catch (Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }

        $this->packageProcedureRepository->updatePackageProcedure(
            $packageProcedure,
            new UpdatePackageProcedureResource([
                'price' => $request->getPrice()
            ])
        );
 
        return $this->respondNoContent();
    }
}
