<?php

declare(strict_types=1);

namespace App\Services\TransactionSummary\Resources;

use App\Database\Entities\PatientVisit;
use App\Database\Entities\UserGuest;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateTransactionSummary extends DataTransferObject
{
    public UserGuest $createdBy;

    public PatientVisit $patientVisit;

    public string $paymentMethod;

    public ?string $remarks = null;

    public string $totalAmount;

    public function getCreatedBy(): UserGuest
    {
        return $this->createdBy;
    }

    public function setCreatedBy(UserGuest $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getPatientVisit(): PatientVisit
    {
        return $this->patientVisit;
    }

    public function setPatientVisit(PatientVisit $patientVisit): self
    {
        $this->patientVisit = $patientVisit;

        return $this;
    }

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function setRemarks(?string $remarks): self
    {
        $this->remarks = $remarks;

        return $this;
    }

    public function getTotalAmount(): string
    {
        return $this->totalAmount;
    }

    public function setTotalAmount(string $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }


}
