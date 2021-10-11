<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Schemas\PatientVisitSchema;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method \App\Database\Entities\Patient getPatient()
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="patient_visits"
 * )
 */
final class PatientVisit extends AbstractEntity
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
     *
     * @var \App\Database\Entities\UserGuest
     */
    protected UserGuest $createdBy;


    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\Patient",
     *     inversedBy="patientVisits",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id")
     *
     * @var \App\Database\Entities\Patient
     */
    protected Patient $patient;

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
            'active' => 'nullable|boolean',
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
            'active' => 'nullable|boolean',
            'attendingDoctor' => 'string',
            'createdBy' => \sprintf('required|%s', $this->instanceOfRuleAsString(UserGuest::class)),
            'patient' => \sprintf('required|%s', $this->instanceOfRuleAsString(Patient::class)),
            'patientBp' => 'required|string',
            'patientHeight' => 'required|string',
            'patientWeight' => 'required|string',
            'remarks' => 'string',
        ];
    }

    protected function getIdProperty(): string
    {
       return 'id';
    }
}
