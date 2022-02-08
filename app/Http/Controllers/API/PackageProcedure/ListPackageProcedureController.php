<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PackageProcedure;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\Packages\PackagesResource;
use App\Repositories\Interfaces\PackageRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class ListPackageProcedureController extends AbstractAPIController
{
    private PackageRepositoryInterface $packageRepository;

    public function __construct(PackageRepositoryInterface $packageRepository) {
        $this->packageRepository = $packageRepository;
    }

    public function __invoke(): JsonResource
    {
        $packages = $this->packageRepository->all();

        return new PackagesResource($packages);
    }
}
