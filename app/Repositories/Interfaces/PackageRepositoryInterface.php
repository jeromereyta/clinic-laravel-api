<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use App\Database\Entities\Package;
use App\Services\PackageProcedureService\Resources\CreatePackageResource;

interface PackageRepositoryInterface
{
    /**
     * @return mixed
     */
    public function all(): array;

    public function create(CreatePackageResource $resource): Package;

    public function deletePackage(Package  $package): void;

    public function findById(int $id): Package;

    public function findByName(string $name): ?array;

    public function updatePackage(Package $package, CreatePackageResource $resource): Package;
}
