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
                TransactionSummary::class
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
                'package_id' => $packageProcedure?->getPackage()->getId(),
                'package_name' => $packageProcedure !== null ? $packageProcedure->getPackage()->getName(): '',
            ];
        }

        /** @var TransactionSummary $transaction */
        $transactionNumber = \sprintf(
            '%s-%s-%s',
            $patientVisit->getPatient()->getPatientCode(),
            $this->resource->getCreatedAt()->format('mdY'),
            $this->resource->getTransactionCountThisDay(),
        );

        return [
            'id' => $this->resource->getId(),
            'patient_visit_id' => $this->resource->getPatientVisit()->getId(),
            'transaction_code' => $transactionNumber,
            'payment_method' => $this->resource->getPaymentMethod(),
            'procedures' => $computedProcedures,
            'patient' =>  $patientVisit->getPatient()->getName(),
            'remarks' => $this->resource->getRemarks(),
            'total_amount' => $this->resource->getTotalAmount(),
            'created_at' => (new Carbon($this->resource->getCreatedAt()))->isoFormat('MMMM Do YYYY, h:mm:ss a')
        ];
    }
}
