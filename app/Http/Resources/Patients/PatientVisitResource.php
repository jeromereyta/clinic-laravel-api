<?php

declare(strict_types=1);

namespace App\Http\Resources\Patients;

use App\Database\Entities\PatientVisit;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\FileUpload\FileUploadsResource;
use App\Http\Resources\Resource;
use Carbon\Carbon;

final class PatientVisitResource extends Resource
{
    /**
     * Return response for this resource.
     *
     * @return mixed[]
     * @throws InvalidResourceTypeException
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
        $createdAt = $this->resource->getCreatedAt();
        $localDate = new Carbon($createdAt);
        $patient = $this->resource->getPatient();

        $files = [];

        if ($this->resource->getFileUploads() !== null) {
            $files = new FileUploadsResource($this->resource->getFileUploads()->toArray());
        }

        $procedures = [];

        if ($this->resource->getPatientProcedures() !== null) {
            $procedures = $this->resource->getPatientProcedures()->toArray();
        }

        $date = new Carbon($localDate->toDateString());

        $todayDate = new Carbon((new Carbon())->toDateString());

        $isPast = $date->gt($todayDate);

        return [
            'id' => $this->resource->getId(),
            'attending_doctor' => $this->resource->getAttendingDoctor(),
            'patient_code' => $patient->getPatientCode(),
            'patient_name' => $patient->getName(),
            'patient_bp' => $this->resource->getPatientBP(),
            'patient_height' => $this->resource->getPatientHeight(),
            'patient_weight' => $this->resource->getPatientWeight(),
            'procedures' => new PatientProceduresResource($procedures),
            'remarks' => $this->resource->getRemarks(),
            'total_summary' => $this->resource->getTransactionSummary(),
            'files' => $files,
            'created_by' => $this->resource->getCreatedById(),
            'is_past' => $isPast,
            'created_at' => $localDate->setTimezone('Asia/Taipei')->toDayDateTimeString(),
        ];
    }
}
