<?php

namespace App\Http\Requests\API\FileUpload;

use App\Http\Requests\BaseRequest;

final class CreateFileUploadRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getFileTypeId(): int
    {
        return $this->getInt('file_type_id');
    }

    public function getPatientVisitId(): int
    {
        return $this->getInt('patient_visit_id');
    }

    public function getDescription(): string
    {
        return $this->getString('description');
    }

    public function getPath(): string
    {
        return $this->getString('path');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'file' => 'required',
            'description' => 'required|string',
            'file_type_id' => 'required|int',
            'patient_visit_id' => 'required|int',
        ];
    }
}
