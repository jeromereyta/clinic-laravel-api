<?php /** @noinspection ALL */

declare(strict_types=1);

namespace App\Database\Schemas;

use App\Enum\UserTypeEnum;
use DateTimeInterface;

/**
 * @method bool isActive()
 * @method string getAge()
 * @method string getBarangay()
 * @method DateTimeInterface getBirthDate()
 * @method string getCity()
 * @method string getCivilStatus()
 * @method string getCountry()
 * @method string getCreatedById()
 * @method string getEmail()
 * @method string getGender()
 * @method string getName()
 * @method string getPatientCode()
 * @method string getPhoneNumber()
 * @method string getProfilePicture()
 * @method string getRegion()
 * @method string getStreetAddress()
 * @method string getUpdatedById()
 * @method self setActive(bool $active)
 * @method self setAge(string $age)
 * @method self setBarangay(string $barangay)
 * @method self setBirthDate(DateTimeInterface $birthDate)
 * @method self setCity(string $city)
 * @method self setCivilStatus(string $civilStatus)
 * @method self setCountry(string $country)
 * @method self setEmail(string $email)
 * @method self setGender(string $gender)
 * @method self setName(string $name)
 * @method self setPatientCode(string $patientCode)
 * @method self setPhoneNumber(string $phoneNumber)
 * @method self setRegion(string $region)
 * @method self setStreetAddress(string $streetAddress)
 * @method self setProfilePicture(string $profilePicture)
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
     * @ORM\Column(name="`barangay`", type="string")
     *
     * @var string
     */
    protected string $barangay;

    /**
     * @ORM\Column(name="`birth_date`", type="datetime")
     *
     *
     * @var DateTimeInterface
     */
    protected DateTimeInterface $birthDate;

    /**
     * @ORM\Column(name="`city`", type="string")
     *
     * @var string
     */
    protected string $city;

    /**
     * @ORM\Column(name="`civil_status`", type="string")
     *
     * @var string
     */
    protected string $civilStatus;

    /**
     * @ORM\Column(name="`country`", type="string")
     *
     * @var string
     */
    protected string $country;

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
     * @ORM\Column(name="`profile_picture`", type="string")
     *
     * @var string
     */
    protected string $profilePicture;

    /**
     * @ORM\Column(name="`province`", type="string")
     *
     * @var string
     */
    protected string $province;

    /**
     * @ORM\Column(name="`street_address`", type="string")
     *
     * @var string
     */
    protected string $streetAddress;

    /**
     * @ORM\Column(name="updated_by_id", type="integer", nullable="true")
     *
     * @var string
     */
    protected string $updatedById;
}
