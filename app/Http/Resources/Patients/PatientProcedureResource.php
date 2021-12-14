<?php

declare(strict_types=1);

namespace App\Http\Resources\Patients;

use App\Database\Entities\PatientProcedure;
use App\Database\Entities\Procedure;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;

final class PatientProcedureResource extends Resource
{
    /**
     * Return response for this resource.
     *
     * @return mixed[]
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof PatientProcedure) === false) {
            throw new InvalidResourceTypeException(
                Procedure::class,
                \get_class($this->resource)
            );
        }
        /** @var Procedure $procedure */
        $procedure = $this->resource->getProcedure();

        return [
            'id' => $this->resource->getId(),
            'name' => $procedure->getName(),
            'patient_procedure_description' => $this->resource->getDescription(),
            'category_procedure_id' => $procedure->getCategoryProcedureId(),
            'description' => $procedure->getDescription(),
            'price' => $procedure->getPrice(),
        ];
    }
}
