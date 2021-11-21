<?php

declare(strict_types=1);

namespace App\Http\Resources\CategoryProcedures;

use App\Database\Entities\CategoryProcedure;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;

final class CategoryProcedureResource extends Resource
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
        if (($this->resource instanceof CategoryProcedure) === false) {
            throw new InvalidResourceTypeException(
                CategoryProcedure::class,
                \get_class($this->resource)
            );
        }

        return [
            'id' => $this->resource->getId(),
            'name' => $this->resource->getName(),
            'description' => $this->resource->getDescription(),
            'type' => \ucfirst($this->resource->getType()),
        ];
    }
}
