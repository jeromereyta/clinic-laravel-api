<?php

namespace App\Http\Requests\API\Procedures;

use App\Http\Requests\BaseRequest;

final class UpdateProcedureRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function isActive(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return $this->getString('name');
    }

    public function getCategoryProcedureId(): int
    {
        return $this->getInt('category_procedure_id');
    }

    public function getDescription(): string
    {
        return $this->getString('description');
    }

    public function getPrice(): string
    {
        return $this->getString('price');
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'price' => 'string',
            'category_procedure_id' => 'required|int',
        ];
    }
}
