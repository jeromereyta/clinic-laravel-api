<?php

declare(strict_types=1);

namespace App\Http\Resources\Procedures;

use App\Database\Entities\Procedure;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;

final class ProcedureResource extends Resource
{
    /**
     * Return response for this resource.
     *
     * @return mixed[]
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof Procedure) === false) {
            throw new InvalidResourceTypeException(
                Procedure::class,
                \get_class($this->resource)
            );
        }

        return [
            'id' => $this->resource->getId(),
            'name' => $this->resource->getName(),
            'category_procedure_id' => $this->resource->getCategoryProcedureId(),
            'description' => $this->resource->getDescription(),
            'price' => $this->resource->getPrice(),
        ];
    }
}
