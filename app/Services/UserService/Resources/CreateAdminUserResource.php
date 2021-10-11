<?php

declare(strict_types=1);

namespace App\Services\UserService\Resources;

use Spatie\DataTransferObject\DataTransferObject;

final class CreateAdminUserResource extends DataTransferObject
{
    public string $email;

    public string $firstName;

    public string $lastName;

    public string $password;

    public string $userType;

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getUserType(): string
    {
        return $this->userType;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setUserType(string $userType): void
    {
        $this->userType = $userType;
    }
}
