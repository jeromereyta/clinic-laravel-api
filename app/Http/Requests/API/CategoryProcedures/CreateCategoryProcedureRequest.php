<?php

namespace App\Http\Requests\API\CategoryProcedures;

use App\Enum\CategoryProcedureTypeEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class CreateCategoryProcedureRequest extends BaseRequest
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

    public function getType(): CategoryProcedureTypeEnum
    {
        $type = $this->getString('type');

        return new CategoryProcedureTypeEnum($type);
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:App\Database\Entities\CategoryProcedure,name',
            'description' => 'required|string',
            'type' => [
                'required',
                'string',
                Rule::in(CategoryProcedureTypeEnum::toArray())
            ],
        ];
    }
}
