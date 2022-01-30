<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PackageProcedure;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PackageProcedure\UpdatePackageRequest;
use App\Repositories\Interfaces\PackageProcedureRepositoryInterface;
use App\Repositories\Interfaces\PackageRepositoryInterface;
use App\Repositories\Interfaces\ProcedureRepositoryInterface;
use App\Services\PackageProcedureService\Resources\CreatePackageProcedureResource;
use App\Services\PackageProcedureService\Resources\CreatePackageResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

class EditPackageController extends AbstractAPIController
{
    private PackageRepositoryInterface $packageRepository;
    private PackageProcedureRepositoryInterface $packageProcedureRepository;
    private ProcedureRepositoryInterface $procedureRepository;

    public function __construct(
        PackageRepositoryInterface $packageRepository,
        PackageProcedureRepositoryInterface $packageProcedureRepository,
        ProcedureRepositoryInterface $procedureRepository
    ) {
        $this->packageProcedureRepository = $packageProcedureRepository;
        $this->packageRepository = $packageRepository;
        $this->procedureRepository = $procedureRepository;
    }

    public function __invoke(int $id, UpdatePackageRequest $request): JsonResource
    {
        $package = null;

        try {
            $package = $this->packageRepository->findById($id);
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage());
        }

        try {
            $package = $this->packageRepository->updatePackage($package, new CreatePackageResource([
                'name' => $request->getName(),
                'description' => $request->getDescription()
            ]));
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage());
        }

        $procedures = $request->getProcedures();

        $this->packageProcedureRepository->deletePackageProcedure($package);

        // @TODO optimize, dont run query inside an iteration or loop.
        foreach ($procedures as $procedure) {
            try {
                $procedureEntity = $this->procedureRepository->findById((int) $procedure['id']);
            } catch (Throwable $throwable) {
                return $this->respondError($throwable->getMessage());
            }

            try {
                $this->packageProcedureRepository->create(new CreatePackageProcedureResource([
                    'package' => $package,
                    'procedure' => $procedureEntity,
                    'price' => $procedure['price'],
                ]));
            } catch (Throwable $throwable) {
                return $this->respondError($throwable->getMessage());
            }
        }

        return $this->respondNoContent();
    }
}
