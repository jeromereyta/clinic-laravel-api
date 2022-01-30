<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\Package;
use App\Database\Entities\PackageProcedure;
use App\Services\PackageProcedureService\Resources\CreatePackageProcedureResource;
use App\Services\PackageProcedureService\Resources\UpdatePackageProcedureResource;

interface PackageProcedureRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all(): array;

    public function create(CreatePackageProcedureResource $resource): PackageProcedure;

    public function deletePackage(PackageProcedure  $packageProcedure): void;

    public function deletePackageProcedure(Package  $package): void;

    public function findById(int $id): PackageProcedure;

    public function findByName(string $name): ?array;

    public function updatePackageProcedure(
        PackageProcedure $packageProcedure,
        UpdatePackageProcedureResource $resource
    ): PackageProcedure;
}
