<?php

declare(strict_types=1);

namespace App\Database\Schemas;

use App\Enum\UserTypeEnum;
use DateTimeInterface;

/**
 * @method bool getPaymentMethod()
 * @method string getRemarks()
 * @method string getTotalAmount()
 * @method string getPatientVisitId()
 * @method self setPaymentMethod(string $paymentMethod)
 * @method self setRemarks(string $remarks)
 * @method self setTotalAmount(string $totalAmount)
 */
trait TransactionSummarySchema
{
    /**
     * @ORM\Column(name="created_by_id", type="integer")
     */
    protected int $createdById;

    /**
     * @ORM\Column(name="deleted_at",type="datetime", nullable=true)
     */
    public ?DateTimeInterface $deletedAt = null;

    /**
     * @ORM\Column(name="payment_method", type="text")
     */
    protected string $paymentMethod;

    /**
     * @ORM\Column(name="remarks", type="text", nullable=true)
     */
    protected ?string $remarks = null;

    /**
     * @ORM\Column(name="total_amount", type="string")
     */
    protected string $totalAmount;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected int $id;

    /**
     * @ORM\Column(name="patient_visit_id", type="integer")
     */
    protected int $patientVisitId;
}
