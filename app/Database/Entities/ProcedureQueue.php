<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Schemas\ProcedureQueueSchema;
use App\Enum\ProcedureQueueTypeEnum;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method UserGuest getCreatedBy()
 * @method ?UserGuest getUpdatedBy()
 * @method PatientProcedure getPatientProcedure()
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="procedure_queues"
 * )
 */
class ProcedureQueue extends AbstractEntity
{
    use ProcedureQueueSchema;

    /**
     * @ORM\OneToOne (
     *     targetEntity="App\Database\Entities\PatientProcedure",
     *     inversedBy="procedureQueue",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="patient_procedure_id", referencedColumnName="id")
     */
    public PatientProcedure $patientProcedure;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\UserGuest",
     *     inversedBy="createdPatients",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="created_by_id", referencedColumnName="user_guest_id")
     */
    protected UserGuest $createdBy;

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

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getCreatedById(): int
    {
        return $this->createdById;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPatientProcedureId(): int
    {
        return $this->patientProcedureId;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getQueueNumber(): int
    {
        return $this->queueNumber;
    }

    public function getUpdatedById(): int
    {
        return $this->updatedById;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function setPatientProcedure(PatientProcedure $patientProcedure): self
    {
        $this->patientProcedure = $patientProcedure;
        $this->patientProcedureId = $patientProcedure->getId();
        return $this;
    }

    public function setCreatedBy(UserGuest $createdBy): self
    {
        $this->createdBy = $createdBy;
        $this->createdById = $createdBy->getId();
        return $this;
    }

    public function setUpdatedBy(?UserGuest $updatedBy): self
    {
        $this->updatedBy = $updatedBy;
        $this->updatedById = $updatedBy->getId();
        return $this;
    }

    public function setCreatedById(int $createdById): self
    {
        $this->createdById = $createdById;
        return $this;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setPatientProcedureId(int $patientProcedureId): self
    {
        $this->patientProcedureId = $patientProcedureId;
        return $this;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function setQueueNumber(int $queueNumber): self
    {
        $this->queueNumber = $queueNumber;
        return $this;
    }

    public function setUpdatedById(int $updatedById): self
    {
        $this->updatedById = $updatedById;
        return $this;
    }

    /**
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
            'patientProcedure' => \sprintf('required|%s', $this->instanceOfRuleAsString(PatientProcedure::class)),
            'createdBy' => \sprintf('required|%s', $this->instanceOfRuleAsString(UserGuest::class)),
            'updatedBy' => \sprintf('%s', $this->instanceOfRuleAsString(UserGuest::class)),
            'status' => \sprintf('required|string|%s', $this->inRuleString(ProcedureQueueTypeEnum::toArray())),
            'queueNumber' => 'required|integer',
        ];
    }

    /**
     * @return mixed[]
     */
    protected function doToArray(): array
    {
        return [
            'queue_number' => $this->getQueueNumber(),
            'status' => $this->getStatus(),
            'created_by_id' => $this->getCreatedById(),
            'updated_by_id' => $this->getUpdatedById(),
        ];
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
