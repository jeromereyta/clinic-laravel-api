<?php

declare(strict_types=1);

namespace App\Http\Resources\Transactions;

use App\Database\Entities\TransactionSummary;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Patients\PatientVisitResource;
use App\Http\Resources\Resource;
use App\Services\Identifiers\Interfaces\IdentifierEncoderInterface;
use Carbon\Carbon;

final class TransactionResource extends Resource
{
    private IdentifierEncoderInterface $identifierEncoder;

    public function __construct($resource, IdentifierEncoderInterface $identifierEncoder)
    {
        $this->identifierEncoder = $identifierEncoder;

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
        if (($this->resource instanceof TransactionSummary) === false) {
            throw new InvalidResourceTypeException(
                TransactionSummary::class,
                \get_class($this->resource)
            );
        }

        $patientVisit = $this->resource->getPatientVisit();

        $patientProcedures = [];

        if ($patientVisit->getPatientProcedures() !== null) {
            $patientProcedures = $patientVisit->getPatientProcedures();
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
                'package_id' => $packageProcedure !== null ? $packageProcedure->getPackage()->getId(): null,
                'package_name' => $packageProcedure !== null ? $packageProcedure->getPackage()->getName(): '',
            ];
        }


        return [
            'id' => $this->resource->getId(),
            'patient_visit_id' => $this->resource->getPatientVisit()->getId(),
            'transaction_code' => $this->identifierEncoder->encode((int) $this->resource->getId()) ?? null,
            'payment_method' => $this->resource->getPaymentMethod(),
            'procedures' => $computedProcedures,
            'patient' =>  $patientVisit->getPatient()->getName(),
            'remarks' => $this->resource->getRemarks(),
            'total_amount' => $this->resource->getTotalAmount(),
            'created_at' => (new Carbon($this->resource->getCreatedAt()))->isoFormat('MMMM Do YYYY, h:mm:ss a')
        ];
    }
}
