<?php

declare(strict_types=1);

namespace App\Http\Resources\CategoryProcedures;

use App\Http\Resources\Resource;

final class CategoryProceduresResource extends Resource
{
    /**
     * @param mixed[] $categoryProcedures
     */
    public function __construct(array $categoryProcedures)
    {
        parent::__construct($categoryProcedures);
    }

    /**
     * Return response for this resource.
     *
     * @return mixed[]
     */
    protected function getResponse(): array
    {
        $results = [];

        foreach ($this->resource as $categoryProcedure) {
            $results[] = new CategoryProcedureResource($categoryProcedure);
        }

        return $results;
    }
}
