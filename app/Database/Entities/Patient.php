<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Schemas\PatientSchema;
use Carbon\Carbon;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method \App\Database\Entities\UserGuest getCreatedBy()
 * @method null|\App\Database\Entities\UserGuest getUpdatedBy()
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="patients"
 * )
 */
class Patient extends AbstractEntity
{
    use PatientSchema;

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
     *     inversedBy="createdPatients",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="created_by_id", referencedColumnName="user_guest_id")
     *
     * @var \App\Database\Entities\UserGuest
     */
    protected UserGuest $createdBy;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Database\Entities\PatientVisit",
     *     mappedBy="patient",
     *     cascade={"persist"}
     * )
     *
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $patientVisits;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\UserGuest",
     *     inversedBy="updatedPatients",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="updated_by_id", referencedColumnName="user_guest_id")
     *
     * @var null|\App\Database\Entities\UserGuest
     */
    protected ?UserGuest $updatedBy;

    public function __construct() {
        $this->patientVisits = new ArrayCollection();

        parent::__construct();
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function getAge(): string
    {
        return (string) $this->getBirthDate()->diff(Carbon::now())->y;
    }

    public function getBirthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    public function getCivilStatus(): string
    {
        return $this->civilStatus;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getCreatedById(): string
    {
        return $this->createdById;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getGender(): string
    {
        return $this->gender;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPatientCode(): string
    {
        return $this->patientCode;
    }

    /**
     * @return mixed[]
     */
    public function getPatientVisits(): ArrayCollection
    {
        return $this->patientVisits;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function getUpdatedById(): ?string
    {
        return $this->updatedById;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function setAge(string $age): void
    {
        $this->age = $age;
    }

    public function setBirthDate(DateTimeInterface $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function setCivilStatus(string $civilStatus): void
    {
        $this->civilStatus = $civilStatus;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setCreatedBy(UserGuest $user): self
    {
        $this->createdBy = $user;
        $this->createdById = (string)$user->getId();

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getBarangay(): string
    {
        return $this->barangay;
    }

    /**
     * @param string $barangay
     *
     * @return Patient
     */
    public function setBarangay(string $barangay): Patient
    {
        $this->barangay = $barangay;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): Patient
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getProfilePicture(): string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(string $profilePicture): self
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    /**
     * @return string
     */
    public function getProvince(): string
    {
        return $this->province;
    }

    public function setProvince(string $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getStreetAddress(): string
    {
        return $this->streetAddress;
    }

    public function setStreetAddress(string $streetAddress): self
    {
        $this->streetAddress = $streetAddress;

        return $this;
    }

    public function setPatientCode(string $patientCode): self
    {
        $this->patientCode = $patientCode;

        return $this;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function setUpdatedBy(?UserGuest $user = null): self
    {
        if ($user === null) {
            return $user;
        }

        $this->updatedBy = $user;
        $this->updatedById = (string)$user->getId();

        return $this;
    }

    /**
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
            'active' => 'nullable|boolean',
            'age' => 'required|string',
            'birthDate' => 'required|date',
            'civilStatus' => 'required|string',
            'createdBy' => \sprintf('required|%s', $this->instanceOfRuleAsString(UserGuest::class)),
            'email' => 'required|email|'. $this->uniqueRuleAsString('email'),
            'name' => 'required|string',
            'patientCode' => 'required|string'. $this->uniqueRuleAsString('patient_code'),
            'phoneNumber' => 'required|string',
            'profilePicture' => 'required|string',
            'updatedBy' => \sprintf('nullable|%s', $this->instanceOfRuleAsString(UserGuest::class)),
        ];
    }

    /**
     * @return mixed[]
     */
    protected function doToArray(): array
    {
        return [
            'active' => $this->isActive(),
            'age' => $this->getAge(),
            'birth_date' => $this->getBirthDate(),
            'civil_status' => $this->getCivilStatus(),
            'created_by_id' => $this->getCreatedById(),
            'email' => $this->getEmail(),
            'name' => $this->getName(),
            'patient_code' => $this->getPatientCode(),
            'phone_number' => $this->getPhoneNumber(),
            'profile_picture' => $this->getProfilePicture(),
            'updated_by_id' => $this->getUpdatedById(),
        ];
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}