<?php

namespace App\Http\Requests\API\Patients;

use App\Database\Entities\Patient;
use App\Database\Entities\UserGuest;
use App\Http\Requests\BaseRequest;
use Carbon\Carbon;
use DateTimeInterface;

final class CreatePatientRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getAttendingDoctor(): string
    {
        return $this->getString('attending_doctor');
    }

    public function getBarangay(): string
    {
        return $this->getString('barangay');
    }

    public function getBirthDate(): DateTimeInterface
    {
        $birthDate = $this->getString('birth_date');

        return Carbon::parse($birthDate);
    }

    public function getCity(): string
    {
        return $this->getString('city');
    }

    public function getCivilStatus(): string
    {
        return $this->getString('civil_status');
    }

    public function getEmail(): string
    {
        return $this->getString('email');
    }

    public function getGender(): string
    {
        return $this->getString('gender');
    }

    public function getName(): string
    {
        return $this->getString('name');
    }

    public function getPatientBp(): string
    {
        return $this->getString('patient_bp');
    }

    public function getPatientHeight(): string
    {
        return $this->getString('patient_height');
    }

    public function getPatientWeight(): string
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

    public function getProvince(): string
    {
        return $this->getString('province');
    }

    public function getStreetAddress(): string
    {
        return $this->getString('street_address');
    }

    public function getRemarks(): string
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
            'barangay' => 'required|string',
            'birth_date' => 'required|date',
            'city' => 'required|string',
            'civil_status' => 'required|string',
            'email' => 'required|max:255',
            'gender' => 'required|string',
            'name' => 'required|string|unique:App\Database\Entities\Patient,name',
            'patient_bp' => 'required|string',
            'patient_height' => 'required|string',
            'patient_weight' => 'required|string',
            'phone_number' => 'required|string',
            'mobile_number' => 'required|string',
            'province' => 'required|string',
            'street_address' => 'required|string',
            'remarks' => 'string',
        ];
    }
}
