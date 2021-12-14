<?php

declare(strict_types=1);

namespace App\Services\PatientService\Resources;

use App\Database\Entities\PatientVisit;
use App\Database\Entities\Procedure;
use App\Database\Entities\UserGuest;
use Spatie\DataTransferObject\DataTransferObject;

final class CreatePatientProcedureResource extends DataTransferObject
{
    public UserGuest $createdBy;

    public PatientVisit $patientVisit;

    public ?string $description = null;

    /**
     * @var mixed[]
     */
    public array $procedures = [];

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

    /**
     * @return mixed[]
     */
    public function getProcedures(): array
    {
        return $this->procedures;
    }

    /**
     * @param mixed[] $procedures
     */
    public function setProcedure(array $procedures): self
    {
        $this->procedures = $procedures;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description = null): self
    {
        $this->description = $description;

        return $this;
    }


}
