<?php

declare(strict_types=1);

namespace App\Services\ProcedureQueue\Resources;

use App\Database\Entities\PatientProcedure;
use App\Database\Entities\UserGuest;
use App\Enum\ProcedureQueueTypeEnum;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateProcedureQueueResource extends DataTransferObject
{
    public PatientProcedure $patientProcedure;

    public UserGuest $createdBy;

    public ProcedureQueueTypeEnum $status;

    public int $queueNumber;

    public function getPatientProcedure(): PatientProcedure
    {
        return $this->patientProcedure;
    }

    public function getCreatedBy(): UserGuest
    {
        return $this->createdBy;
    }

    public function getStatus(): ProcedureQueueTypeEnum
    {
        return $this->status;
    }

    public function getQueueNumber(): int
    {
        return $this->queueNumber;
    }

    public function setPatientProcedure(PatientProcedure $patientProcedure): self
    {
        $this->patientProcedure = $patientProcedure;
        return $this;
    }

    public function setCreatedBy(UserGuest $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function setStatus(ProcedureQueueTypeEnum $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function setQueueNumber(int $queueNumber): self
    {
        $this->queueNumber = $queueNumber;
        return $this;
    }
}
