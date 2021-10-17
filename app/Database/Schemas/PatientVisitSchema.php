<?php

declare(strict_types=1);

namespace App\Database\Schemas;

use App\Enum\UserTypeEnum;
use DateTimeInterface;

/**
 * @method null|string getAttendingDoctor()
 * @method null|string getPatientBp()
 * @method null|string getPatientHeight()
 * @method null|string getWeight()
 * @method null|string getRemarks()
 */
trait PatientVisitSchema
{
    /**
     * @ORM\Column(name="attending_doctor", type="string", nullable="true")
     *
     * @var null|string
     */
    protected ?string $attendingDoctor;

    /**
     * @ORM\Column(name="created_by_id", type="integer")
     *
     * @var string
     */
    protected string $createdById;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected int $id;

    /**
     * @ORM\Column(name="patient_id", type="integer")
     *
     * @var string
     */
    protected string $patientId;

    /**
     * @ORM\Column(name="patient_bp", type="string")
     *
     * @var string
     */
    protected string $patientBP;

    /**
     * @ORM\Column(name="patient_height", type="string")
     *
     * @var string
     */
    protected string $patientHeight;

    /**
     * @ORM\Column(name="patient_weight", type="string")
     *
     * @var string
     */
    protected string $patientWeight;

    /**
     * @ORM\Column(name="remarks", type="string", nullable="true")
     *
     * @var string
     */
    protected string $remarks;
}
