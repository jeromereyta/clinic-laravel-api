<?php

namespace App\Http\Requests\API\Patients;

use App\Database\Entities\Patient;
use App\Database\Entities\UserGuest;
use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Validation\Rule;

final class CreatePatientRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getAttendingDoctor():  ?string
    {
        return $this->getString('attending_doctor');
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

    public function getGender(): ?string
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

    public function getPatientBp(): ?string
    {
        return $this->getString('patient_bp');
    }

    public function getPatientHeight(): ?string
    {
        return $this->getString('patient_height');
    }

    public function getPatientWeight(): ?string
    {
        return $this->getString('patient_weight');
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

    public function getRemarks(): ?string
    {
        return $this->getString('remarks');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'attending_doctor' => 'string',
            'barangay' => '',
            'birth_date' => 'required|date',
            'city' => 'string',
            'civil_status' => 'required|string',
            'email' => '',
            'gender' => 'required|string',
            'first_name' =>'required|string',
            'middle_name' => '',
            'last_name' =>'required|string',
            'patient_bp' => 'string',
            'patient_height' => 'string',
            'patient_weight' => 'string',
            'phone_number' => 'string',
            'mobile_number' => 'string',
            'province' => '',
            'street_address' => '',
            'remarks' => '',
        ];
    }
}
