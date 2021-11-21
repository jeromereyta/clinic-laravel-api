<?php

declare(strict_types=1);

namespace App\Http\Resources\Patients;

use App\Http\Resources\Resource;

final class AllPatientVisitsResource extends Resource
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

        foreach ($this->resource as $patientVisit) {
            $results[] = new PatientWithVisitsDetailResource($patientVisit);
        }

        return $results;
    }
}
