<?php

declare(strict_types=1);

namespace App\Services\PatientService\Resources;

use App\Database\Entities\UserGuest;
use DateTimeInterface;
use Spatie\DataTransferObject\DataTransferObject;

final class CreatePatientResource extends DataTransferObject
{
    public bool $active;

    public string $age;

    public DateTimeInterface $birthDate;

    public string $civilStatus;

    public string $email;

    public string $name;

    public string $phoneNumber;

    public ?string $profilePicture;

    public UserGuest $updatedBy;

    public string $patientCode;

    public UserGuest $createdBy;

    public $gender;

    public function getActive(): bool
    {
        return $this->active;
    }

    public function getAge(): string
    {
        return $this->age;
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

    public function getPatientCode(): string
    {
        return $this->patientCode;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
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

    public function setAge(string $age): self
    {
        $this->age = $age;

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
}
