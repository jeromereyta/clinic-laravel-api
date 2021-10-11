<?php

declare(strict_types=1);

namespace App\Database\Schemas;

use App\Enum\UserTypeEnum;
use DateTimeInterface;

/**
 * @method bool isActive()
 * @method string getAge()
 * @method DateTimeInterface getBirthDate()
 * @method string getCivilStatus()
 * @method string getCreatedById()
 * @method string getEmail()
 * @method string getGender()
 * @method string getName()
 * @method string getPatientCode()
 * @method string getPhoneNumber()
 * @method string getUpdatedById()
 * @method self setActive(bool $active)
 * @method self setAge(string $age)
 * @method self setBirthDate(DateTimeInterface $birthDate)
 * @method self setCivilStatus(string $civilStatus)
 * @method self setEmail(string $email)
 * @method self setGender(string $gender)
 * @method self setName(string $name)
 * @method self setPatientCode(string $patientCode)
 * @method self setPhoneNumber(string $phoneNumber)
 */
trait PatientSchema
{
    /**
     * @ORM\Column(name="`active`", type="boolean")
     *
     * @var bool
     */
    protected bool $active = true;

    /**
     * @ORM\Column(name="`age`", type="string")
     *
     * @var string
     */
    protected string $age;

    /**
     * @ORM\Column(name="`birth_date`", type="datetime")
     *
     *
     * @var DateTimeInterface
     */
    protected DateTimeInterface $birthDate;

    /**
     * @ORM\Column(name="`civil_status`", type="string")
     *
     * @var string
     */
    protected string $civilStatus;

        /**
         * @ORM\Column(name="created_by_id", type="integer")
         *
         * @var string
         */
        protected string $createdById;

    /**
     * @ORM\Column(name="`email`", type="string")
     *
     * @var string
     */
    protected string $email;

    /**
     * @ORM\Column(name="`gender`", type="string")
     *
     * @var string
     */
    protected string $gender;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected int $id;

    /**
     * @ORM\Column(name="`name`", type="string")
     *
     * @var string
     */
    protected string $name;

    /**
     * @ORM\Column(name="`patient_code`", type="string")
     *
     * @var string
     */
    protected string $patientCode;

    /**
     * @ORM\Column(name="`phone_number`", type="string")
     *
     * @var string
     */
    protected string $phoneNumber;

    /**
     * @ORM\Column(name="updated_by_id", type="integer", nullable="true")
     *
     * @var string
     */
    protected string $updatedById;
}
