<?php

declare(strict_types=1);

namespace App\Http\Resources\Patients;

use App\Database\Entities\Patient;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;

final class PatientResource extends Resource
{
    /**
     * Return response for this resource.
     *
     * @return mixed[]
     * @throws \App\Exceptions\InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof Patient) === false) {
            throw new InvalidResourceTypeException(
                Patient::class,
                \get_class($this->resource)
            );
        }

        $birthDate = $this->resource->getBirthDate()->format('Y-m-d');
        $createdAt = $this->resource->getCreatedAtAsString();
        $updatedAt = $this->resource->getUpdatedAtAsString();

        return [
            'id' => $this->resource->getPatientCode(),
            'active' => $this->resource->getName(),
            'age' => $this->resource->getAge(),
            'birth_date' => $birthDate,
            'barangay' => $this->resource->getBarangay(),
            'civil_status' => $this->resource->getCivilStatus(),
            'city' => $this->resource->getCity(),
            'email' => $this->resource->getEmail(),
            'gender' => $this->resource->getGender(),
            'name' => $this->resource->getName(),
            'phone_number' => $this->resource->getPhoneNumber(),
            'profile_picture' => $this->resource->getProfilePicture(),
            'province' => $this->resource->getProvince(),
            'street_address' => $this->resource->getStreetAddress(),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt
        ];
    }
}
