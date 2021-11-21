<?php

namespace App\Http\Requests\API\Patients;

use App\Http\Requests\BaseRequest;

final class UploadPatientProfileRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getPatientCode(): string
    {
        return $this->getString('patient_code');
    }

    public function getImageFile()
    {
        return $this->file('image');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'patient_code' => 'required|string',
        ];
    }
}
