<?php

namespace App\Http\Requests\API\Patients;

use App\Http\Requests\BaseRequest;

final class CreatePatientVisitRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getAttendingDoctor(): ?string
    {
        return $this->getString('attending_doctor');
    }

    public function getPatientBp(): ?string
    {
        return $this->getString('patient_bp');
    }

    public function getPatientCode(): string
    {
        return $this->getString('patient_code');
    }

    public function getPatientHeight(): ?string
    {
        return $this->getString('patient_height');
    }

    public function getPatientWeight(): ?string
    {
        return $this->getString('patient_weight');
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
            'patient_bp' => 'string',
            'patient_code' => 'string',
            'patient_height' => 'string',
            'patient_weight' => 'string',
            'remarks' => 'string',
        ];
    }
}
