<?php

declare(strict_types=1);

namespace App\Http\Resources\Packages;

use App\Database\Entities\FileType;
use App\Database\Entities\Package;
use App\Database\Entities\PackageProcedure;
use App\Database\Entities\Procedure;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Procedures\ProceduresResource;
use App\Http\Resources\Resource;

final class PackageResource extends Resource
{
    /**
     * Return response for this resource.
     *
     * @return mixed[]
     * @throws InvalidResourceTypeException
     *
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof Package) === false) {
            throw new InvalidResourceTypeException(
                Package::class,
            );
        }

        $packageProcedures = $this->resource->getPackageProcedures();


        $procedures = [];

        /** @var PackageProcedure $packageProcedure */
        foreach ($packageProcedures as $packageProcedure) {
            $procedure = $packageProcedure->getProcedure();

            if ($packageProcedure->getDeletedAt()) {
                continue;
            }

            $procedures[] = [
                'id' => $procedure->getId(),
                'name' => $procedure->getName(),
                'category_procedure_id' => $procedure->getCategoryProcedureId(),
                'description' => $procedure->getDescription(),
                'price' => $packageProcedure->getPrice(),
            ];
        }

        return [
            'id' => $this->resource->getId(),
            'name' => $this->resource->getName(),
            'description' => $this->resource->getDescription(),
            'procedures' => $procedures,
        ];
    }
}
