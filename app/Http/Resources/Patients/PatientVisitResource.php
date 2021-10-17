<?php

declare(strict_types=1);

namespace App\Http\Resources\Patients;

use App\Database\Entities\PatientVisit;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;

final class PatientVisitResource extends Resource
{
    /**
     * Return response for this resource.
     *
     * @return mixed[]
     * @throws \App\Exceptions\InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof PatientVisit) === false) {
            throw new InvalidResourceTypeException(
                PatientVisit::class,
                \get_class($this->resource)
            );
        }

        // did not include updated by since this one record is not updatable
        $createdAt = $this->resource->getCreatedAtAsString();

        return [
            'attending_doctor' => $this->resource->getAttendingDoctor(),
            'patient_bp' => $this->resource->getPatientBP(),
            'patient_height' => $this->resource->getPatientHeight(),
            'patient_weight' => $this->resource->getPatientWeight(),
            'remarks' => $this->resource->getRemarks(),
            'created_by' => $this->resource->getCreatedById(),
            'created_at' => $createdAt,
        ];
    }
}
