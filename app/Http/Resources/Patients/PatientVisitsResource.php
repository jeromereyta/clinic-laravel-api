<?php

declare(strict_types=1);

namespace App\Http\Resources\Patients;

use App\Http\Resources\Resource;

final class PatientVisitsResource extends Resource
{
    /**
     * @param mixed[] $patientVisits
     */
    public function __construct(array $patientVisits)
    {
        parent::__construct($patientVisits);
    }

    /**
     * Return response for this resource.
     *
     * @return mixed[]
     */
    protected function getResponse(): array
    {
        $results = [];

        foreach ($this->resource as $patient) {
            $results[] = new PatientVisitResource($patient);
        }

        return $results;
    }
}
