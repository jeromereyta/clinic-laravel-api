<?php

declare(strict_types=1);

namespace App\Http\Resources\Patients;

use App\Database\Entities\Patient;
use App\Exceptions\InvalidResourceTypeException;
use App\Http\Resources\Resource;
use Carbon\Carbon;

final class PatientResource extends Resource
{
    /**
     * Return response for this resource.
     *
     * @return mixed[]
     * @throws InvalidResourceTypeException
     */
    protected function getResponse(): array
    {
        if (($this->resource instanceof Patient) === false) {
            throw new InvalidResourceTypeException(
                Patient::class,
                \get_class($this->resource)
            );
        }

        $birthDate = $this->resource->getBirthDate()->format('Y/m/d');
        $createdAt = $this->resource->getCreatedAtAsString();
        $updatedAt = $this->resource->getUpdatedAtAsString();
        $localDate = new Carbon($createdAt);

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
            'first_name' => $this->resource->getFirstName(),
            'middle_name' => $this->resource->getMiddleName(),
            'last_name' => $this->resource->getLastName(),
            'phone_number' => $this->resource->getPhoneNumber(),
            'mobile_number' => $this->resource->getMobileNumber(),
            'profile_picture' => $this->resource->getProfilePicture(),
            'province' => $this->resource->getProvince(),
            'street_address' => $this->resource->getStreetAddress(),
            'created_at' => $localDate->setTimezone('Asia/Taipei')->format('g:i a l jS F Y'),
            'updated_at' => $updatedAt
        ];
    }
}
