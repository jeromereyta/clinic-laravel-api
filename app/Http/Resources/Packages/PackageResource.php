<?php

declare(strict_types=1);

namespace App\Http\Resources\Packages;

use App\Database\Entities\FileType;
use App\Database\Entities\Package;
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
                \get_class($this->resource)
            );
        }

        $packageProcedures = $this->resource->getPackageProcedures();


        $procedures = [];

        foreach ($packageProcedures as $packageProcedure) {
            $procedure = $packageProcedure->getProcedure();

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
