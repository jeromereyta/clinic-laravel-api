<?php

namespace App\Http\Requests\API\FileUpload;

use App\Http\Requests\BaseRequest;

final class CreateFileTypeRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return $this->getString('name');
    }

    public function getDescription(): string
    {
        return $this->getString('description');
    }

    public function getType(): string
    {
        return $this->getString('type');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:App\Database\Entities\FileType,name',
            'description' => 'required|string',
            'type' => 'required|string',
        ];
    }
}
