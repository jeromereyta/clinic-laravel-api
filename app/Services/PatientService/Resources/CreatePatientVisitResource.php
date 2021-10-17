<?php

declare(strict_types=1);

namespace App\Services\PatientService\Resources;

use App\Database\Entities\Patient;
use App\Database\Entities\UserGuest;
use Spatie\DataTransferObject\DataTransferObject;

final class CreatePatientVisitResource extends DataTransferObject
{
    public string $attendingDoctor;

    public UserGuest $createdBy;

    public string $patientBp;

    public Patient $patient;

    public string $patientHeight;

    public string $patientWeight;

    public string $remarks;

    public function getAttendingDoctor(): string
    {
        return $this->attendingDoctor;
    }

    public function getCreatedBy(): UserGuest
    {
        return $this->createdBy;
    }

    public function getPatientBp(): string
    {
        return $this->patientBp;
    }

    public function getPatient(): Patient
    {
        return $this->patient;
    }

    public function getPatientHeight(): string
    {
        return $this->patientHeight;
    }

    public function getPatientWeight(): string
    {
        return $this->patientWeight;
    }

    public function getRemarks(): string
    {
        return $this->remarks;
    }

    public function setAttendingDoctor(string $attendingDoctor): self
    {
        $this->attendingDoctor = $attendingDoctor;

        return $this;
    }

    public function setCreatedBy(UserGuest $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function setPatientBp(string $patientBp): self
    {
        $this->patientBp = $patientBp;

        return $this;
    }

    public function setPatient(Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function setPatientHeight(string $patientHeight): self
    {
        $this->patientHeight = $patientHeight;

        return $this;
    }

    public function setPatientWeight(string $patientWeight): self
    {
        $this->patientWeight = $patientWeight;

        return $this;
    }

    public function setRemarks(string $remarks): self
    {
        $this->remarks = $remarks;

        return $this;
    }
}
