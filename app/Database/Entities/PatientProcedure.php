<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Schemas\PatientProcedureSchema;
use App\Database\Schemas\PatientVisitSchema;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method \App\Database\Entities\Procedure getProcedure()
 * @method \App\Database\Entities\PatientVisit getPatientVisit()
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="patient_procedures"
 * )
 */
class PatientProcedure extends AbstractEntity
{
    use PatientProcedureSchema;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\PackageProcedure",
     *     inversedBy="packageProcedure",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="package_procedure_id", referencedColumnName="id")
     */
    protected ?PackageProcedure $packageProcedure;

    /**
     * @ORM\OneToOne (
     *     targetEntity="App\Database\Entities\ProcedureQueue",
     *     mappedBy="patientProcedure",
     *     cascade={"persist"}
     * )
     */
    protected ProcedureQueue $procedureQueue;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    public DateTimeInterface $createdAt;

    /**
     * @var DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    public DateTimeInterface $updatedAt;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\Procedure",
     *     inversedBy="patientProcedures",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="procedure_id", referencedColumnName="id")
     */
    protected Procedure $procedure;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\UserGuest",
     *     inversedBy="createdPatientProcedures",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="created_by_id", referencedColumnName="user_guest_id")
     */
    protected UserGuest $createdBy;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\PatientVisit",
     *     inversedBy="patientProcedures",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="patient_visit_id", referencedColumnName="id")
     */
    protected PatientVisit $patientVisit;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\UserGuest",
     *     inversedBy="updatedPatients",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="updated_by_id", referencedColumnName="user_guest_id")
     *
     * @var null|UserGuest
     */
    protected ?UserGuest $updatedBy;

    public function getPackageProcedure(): ?PackageProcedure
    {
        return $this->packageProcedure;
    }

    public function getCreatedById(): int
    {
        return $this->createdById;
    }

    public function setCreatedById(int $createdById): self
    {
        $this->createdById = $createdById;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getPatientVisitId(): int
    {
        return $this->patientVisitId;
    }

    public function setPatientVisitId(int $patientVisitId): self
    {
        $this->patientVisitId = $patientVisitId;
        return $this;
    }

    public function getProcedureId(): int
    {
        return $this->procedureId;
    }

    public function setProcedureId(int $procedureId): self
    {
        $this->procedureId = $procedureId;
        return $this;
    }

    public function getUpdatedById(): int
    {
        return $this->updatedById;
    }

    public function setUpdatedById(int $updatedById): self
    {
        $this->updatedById = $updatedById;
        return $this;
    }

    public function setPatientVisit(PatientVisit $patientVisit): self
    {
        $this->patientVisit = $patientVisit;
        $this->patientVisitId = $patientVisit->getId();

        return $this;
    }

    public function setProcedure(Procedure $procedure): self
    {
        $this->procedure = $procedure;
        $this->procedureId = (int) $procedure->getId();

        return $this;
    }

    public function setCreatedBy(UserGuest $user): self
    {
        $this->createdBy = $user;
        $this->createdById = $user->getId();

        return $this;
    }

    public function setUpdatedBy(?UserGuest $user = null): self
    {
        if ($user === null) {
            return $user;
        }

        $this->updatedBy = $user;
        $this->updatedById = $user->getId();

        return $this;
    }

    /**
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
        ];
    }

    /**
     * @return mixed[]
     */
    protected function doToArray(): array
    {
        return [
            'created_by_id' => $this->getCreatedById(),
            'patient_visit_id' => $this->getPatientVisitId(),
            'procedure_id' => $this->getProcedureId(),
        ];
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
