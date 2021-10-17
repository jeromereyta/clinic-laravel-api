<?php

declare(strict_types=1);

namespace App\Http\Resources\Patients;

use App\Database\Entities\Patient;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;

final class PatientsResource extends Resource
{
    /**
     * @param mixed[] $patients
     */
    public function __construct(array $patients)
    {
        parent::__construct($patients);
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
            $results[] = new PatientResource($patient);
        }

        return $results;
    }
}
