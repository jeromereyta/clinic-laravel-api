<?php

declare(strict_types=1);

namespace App\Services\PatientService\Resources;

use App\Database\Entities\UserGuest;
use DateTimeInterface;
use Spatie\DataTransferObject\DataTransferObject;

final class CreatePatientResource extends DataTransferObject
{
    public bool $active;

    public string $barangay;

    public DateTimeInterface $birthDate;

    public string $civilStatus;

    public string $city;

    public string $email;

    public string $name;

    public string $firstName;

    public ?string $middleName = null;

    public string $lastName;

    public string $phoneNumber;

    public string $mobileNumber;

    public ?string $profilePicture;

    public UserGuest $updatedBy;

    public string $patientCode;

    public string $province;

    public string $streetAddress;

    public UserGuest $createdBy;

    public string $gender;

    public function getActive(): bool
    {
        return $this->active;
    }

    public function getBirthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    public function getCivilStatus(): string
    {
        return $this->civilStatus;
    }

    public function getCreatedBy(): UserGuest
    {
        return $this->createdBy;
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

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPatientCode(): string
    {
        return $this->patientCode;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getMobileNumber(): string
    {
        return $this->mobileNumber;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function getUpdatedBy(): UserGuest
    {
        return $this->updatedBy;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function setBirthDate(DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function setCivilStatus(string $civilStatus): self
    {
        $this->civilStatus = $civilStatus;

        return $this;
    }

    public function setCreatedBy(UserGuest $createdBy): self
    {
        $this->createdBy = $createdBy;

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

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function setMiddleName(?string $middleName = null): self
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function setMobileNumber(string $mobileNumber): self
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }

    public function setProfilePicture(string $profilePicture): self
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function setUpdatedById(UserGuest $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

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
     * @return CreatePatientResource
     */
    public function setBarangay(string $barangay): CreatePatientResource
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

    /**
     * @param string $city
     *
     * @return CreatePatientResource
     */
    public function setCity(string $city): CreatePatientResource
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return 'Philippines';
    }

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

}
