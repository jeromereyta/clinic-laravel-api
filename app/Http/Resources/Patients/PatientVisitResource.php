<?php

declare(strict_types=1);

namespace App\Http\Resources\Patients;

use App\Database\Entities\PatientVisit;
use App\Database\Entities\TransactionSummary;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\FileUpload\FileUploadsResource;
use App\Http\Resources\Resource;
use App\Http\Resources\Transactions\TransactionResource;
use App\Services\Identifiers\Interfaces\IdentifierEncoderInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

final class PatientVisitResource extends Resource
{
    private IdentifierEncoderInterface $identifierEncoder;

    public function __construct($resource)
    {
        $this->identifierEncoder = app::make(IdentifierEncoderInterface::class);
        parent::__construct($resource);
    }

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

        $patientProcedures = [];

        if ($this->resource->getPatientProcedures() !== null) {
            $patientProcedures = $this->resource->getPatientProcedures();
        }

        $computedProcedures = [];

        foreach ($patientProcedures as $patientProcedure) {

            $procedure = $patientProcedure->getProcedure();

            $packageProcedure = $patientProcedure->getPackageProcedure() ?? null;

            $price = $procedure->getPrice();

            if ($packageProcedure !== null) {
                $price = $packageProcedure->getPrice();
            }

            $computedProcedures[] = [
                'patient_procedure_id' => $patientProcedure->getId(),
                'id' => $procedure->getId(),
                'name' => $procedure->getName(),
                'patient_procedure_description' => $procedure->getDescription(),
                'category_procedure_id' => $procedure->getCategoryProcedureId(),
                'description' => $procedure->getDescription(),
                'price' => $price,
                'package_id' => $packageProcedure?->getPackage()->getId()  ?? null,
                'package_name' => $packageProcedure !== null ? $packageProcedure->getPackage()->getName(): '',
                'status' => $patientProcedure->getProcedureQueue()?->getStatus() ?? null,
                'queue_number' => $patientProcedure->getProcedureQueue()?->getId(),
            ];
        }

        $date = new Carbon($localDate->toDateString());

        $todayDate = new Carbon((new Carbon())->toDateString());

        $isPast = $date->lt($todayDate);

        return [
            'id' => $this->resource->getId(),
            'attending_doctor' => $this->resource->getAttendingDoctor(),
            'patient_code' => $patient->getPatientCode(),
            'patient_name' => $patient->getName(),
            'patient_gender' => $patient->getGender(),
            'patient_birth_date' => $patient->getBirthDate() !== null ? (new Carbon($patient->getBirthDate()))->setTimezone('Asia/Taipei')->toDateString(): null,
            'patient_age' => $patient->getAge(),
            'patient_bp' => $this->resource->getPatientBP(),
            'patient_height' => $this->resource->getPatientHeight(),
            'patient_weight' => $this->resource->getPatientWeight(),
            'procedures' => $computedProcedures,
            'remarks' => $this->resource->getRemarks(),
            'total_summary' => new TransactionResource($this->resource->getTransactionSummary(), $this->identifierEncoder),
            'files' => $files,
            'created_by' => $this->resource->getCreatedById(),
            'is_past' => $isPast,
            'created_at' => $localDate->setTimezone('Asia/Taipei')->toDayDateTimeString(),
        ];
    }
}
