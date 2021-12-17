<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Schemas\TransactionSummarySchema;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method \App\Database\Entities\UserGuest getCreatedBy()
 * @method \App\Database\Entities\PatientVisit getPatientVisit()
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="transaction_summary"
 * )
 */
final class TransactionSummary extends AbstractEntity
{
    use TransactionSummarySchema;

    /**
     * @ORM\Column(type="datetime")
     */
    public DateTimeInterface $createdAt;

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
     * @ORM\OneToOne (
     *     targetEntity="App\Database\Entities\PatientVisit",
     *     inversedBy="transactionSummary",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="patient_visit_id", referencedColumnName="id")
     */
    protected PatientVisit $patientVisit;

    /**
     * @ORM\Column(type="datetime")
     */
    public DateTimeInterface $updatedAt;

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getCreatedById(): int
    {
        return $this->createdById;
    }

    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function getTotalAmount(): string
    {
        return $this->totalAmount;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPatientVisitId(): int
    {
        return $this->patientVisitId;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setCreatedBy(UserGuest $createdBy): self
    {
        $this->createdBy = $createdBy;
        $this->createdById = $createdBy->getId();

        return $this;
    }

    public function setPatientVisit(PatientVisit $patientVisit): self
    {
        $this->patientVisit = $patientVisit;
        $this->patientVisitId = $patientVisit->getId();

        return $this;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setCreatedById(int $createdById): self
    {
        $this->createdById = $createdById;

        return $this;
    }

    public function setDeletedAt(?DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function setPaymentMethod(string $paymentMethod): self
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    public function setRemarks(?string $remarks): self
    {
        $this->remarks = $remarks;

        return $this;
    }

    public function setTotalAmount(string $totalAmount): self
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    public function setPatientVisitId(int $patientVisitId): self
    {
        $this->patientVisitId = $patientVisitId;

        return $this;
    }

    /**
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
            'paymentMethod' => 'required|string',
            'createdBy' => \sprintf('required|%s', $this->instanceOfRuleAsString(UserGuest::class)),
            'patientVisit' => \sprintf('required|%s', $this->instanceOfRuleAsString(PatientVisit::class)),
            'remarks' => 'string',
            'totalAmount' => 'required|string',
        ];
    }

    /**
     * @return mixed[]
     */
    protected function doToArray(): array
    {
        return [
            'id' => $this->getId(),
            'paymentMethod' => $this->getPaymentMethod(),
            'createdBy' => $this->getCreatedBy(),
            'patientVisit' => $this->getPatientVisit(),
            'remarks' => $this->getRemarks(),
            'totalAmount' => $this->getTotalAmount(),
            'deletedAt' => $this->getDeletedAt(),
        ];
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
