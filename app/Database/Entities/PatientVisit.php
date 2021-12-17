<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Schemas\PatientVisitSchema;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method \App\Database\Entities\Patient getPatient()
 * @method \App\Database\Entities\PatientProcedure getPatientProcedures()
 * @method \App\Database\Entities\FileUpload getFileUploads()
 * @method \App\Database\Entities\TransactionSummary getTransactionSummary()
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="patient_visits"
 * )
 */
class PatientVisit extends AbstractEntity
{
    use PatientVisitSchema;

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
     *     targetEntity="App\Database\Entities\UserGuest",
     *     inversedBy="patientVisits",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="created_by_id", referencedColumnName="user_guest_id")
     */
    protected UserGuest $createdBy;


    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Database\Entities\PatientProcedure",
     *     mappedBy="patientVisit",
     *     cascade={"persist"}
     * )
     */
    protected ?Collection $patientProcedures = null;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Database\Entities\FileUpload",
     *     mappedBy="patientVisit",
     *     cascade={"persist"}
     * )
     */
    protected ?Collection $fileUploads = null;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\Patient",
     *     inversedBy="patientVisits",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id")
     */
    protected Patient $patient;

    /**
     * @ORM\OneToOne (
     *     targetEntity="App\Database\Entities\TransactionSummary",
     *     mappedBy="patientVisit",
     *     cascade={"persist"}
     * )
     */
    public ?TransactionSummary $transactionSummary = null;

    public function getAttendingDoctor(): ?string
    {
        return $this->attendingDoctor;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getCreatedById(): string
    {
        return $this->createdById;
    }

    public function getPatientId(): string
    {
        return $this->patientId;
    }

    public function getPatientBP(): string
    {
        return $this->patientBP;
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

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setAttendingDoctor(?string $attendingDoctor): self
    {
        $this->attendingDoctor = $attendingDoctor;

        return $this;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setCreatedBy(UserGuest $user): self
    {
        $this->createdBy = $user;
        $this->createdById = (string) $user->getId();

        return $this;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setPatient(Patient $patient): self
    {
        $this->patientId = (string) $patient->getId();
        $this->patient = $patient;

        return $this;
    }

    public function setPatientBP(string $patientBP): self
    {
        $this->patientBP = $patientBP;

        return $this;
    }

    /**
     * @param string $patientHeight
     */
    public function setPatientHeight(string $patientHeight): self
    {
        $this->patientHeight = $patientHeight;

        return $this;
    }

    /**
     * @param string $patientWeight
     */
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

    /**
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
            'attendingDoctor' => 'string',
            'createdBy' => \sprintf('required|%s', $this->instanceOfRuleAsString(UserGuest::class)),
            'patient' => \sprintf('required|%s', $this->instanceOfRuleAsString(Patient::class)),
            'patientBp' => 'required|string',
            'patientHeight' => 'required|string',
            'patientWeight' => 'required|string',
            'remarks' => 'string',
        ];
    }

    /**
     * @return mixed[]
     */
    protected function doToArray(): array
    {
        return [
            'attending_doctor' => $this->getAttendingDoctor(),
            'created_by_id' => $this->getCreatedById(),
            'patient_id' => $this->getPatientId(),
            'patient_bp' => $this->getPatientBP(),
            'patient_height' => $this->getPatientHeight(),
            'patient_weight' => $this->getPatientWeight(),
            'remarks' => $this->getRemarks(),
        ];
    }

    protected function getIdProperty(): string
    {
       return 'id';
    }
}
