<?php

namespace App\Http\Requests\API\Patients;

use App\Database\Entities\Patient;
use App\Database\Entities\UserGuest;
use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use DateTimeInterface;

final class UpdatePatientRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getBarangay(): ?string
    {
        return $this->getString('barangay');
    }

    public function getBirthDate(): DateTimeInterface
    {
        $birthDate = $this->getString('birth_date');

        return Carbon::parse($birthDate);
    }

    public function getCity(): ?string
    {
        return $this->getString('city');
    }

    public function getCivilStatus(): string
    {
        return $this->getString('civil_status');
    }

    public function getEmail(): ?string
    {
        return $this->getString('email');
    }

    public function getGender(): string
    {
        return $this->getString('gender');
    }

    public function getFirstName(): string
    {
        return $this->getString('first_name');
    }

    public function getMiddleName(): ?string
    {
        return $this->getString('middle_name');
    }

    public function getLastName(): string
    {
        return $this->getString('last_name');
    }

    public function getPhoneNumber(): string
    {
        return $this->getString('phone_number');
    }

    public function getMobileNumber(): string
    {
        return $this->getString('mobile_number');
    }

    public function getProvince(): ?string
    {
        return $this->getString('province');
    }

    public function getStreetAddress(): ?string
    {
        return $this->getString('street_address');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'barangay' => '',
            'birth_date' => 'required|date',
            'city' => '',
            'civil_status' => 'required|string',
            'email' => '',
            'gender' => 'required|string',
            'first_name' => 'required|string',
            'middle_name' => '',
            'last_name' => 'required|string',
            'phone_number' => 'required|string',
            'mobile_number' => 'required|string',
            'province' => '',
            'street_address' => '',
        ];
    }
}
