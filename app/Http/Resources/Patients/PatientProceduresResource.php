<?php

declare(strict_types=1);

namespace App\Http\Resources\Patients;

use App\Database\Entities\PatientProcedure;
use App\Http\Resources\Resource;

final class PatientProceduresResource extends Resource
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

        /** @var PatientProcedure $patientProcedure */
        foreach ($this->resource as $patientProcedure) {
            $results[] = new PatientProcedureResource($patientProcedure);
        }

        return $results;
    }
}
