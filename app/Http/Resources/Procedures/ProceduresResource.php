<?php

declare(strict_types=1);

namespace App\Http\Resources\Procedures;

use App\Http\Resources\Resource;

final class ProceduresResource extends Resource
{
    /**
     * @param mixed[] $procedures
     */
    public function __construct(array $procedures)
    {
        parent::__construct($procedures);
    }

    /**
     * Return response for this resource.
     *
     * @return mixed[]
     */
    protected function getResponse(): array
    {
        $results = [];

        foreach ($this->resource as $procedure) {
            $results[] = new ProcedureResource($procedure);
        }

        return $results;
    }
}
