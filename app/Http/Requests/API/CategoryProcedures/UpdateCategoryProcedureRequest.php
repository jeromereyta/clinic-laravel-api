<?php

namespace App\Http\Requests\API\CategoryProcedures;

use App\Enum\CategoryProcedureTypeEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class UpdateCategoryProcedureRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getName(): ?string
    {
        return $this->getString('name');
    }

    public function getDescription(): ?string
    {
        return $this->getString('description');
    }

    public function getType(): ?CategoryProcedureTypeEnum
    {
        $type = $this->getString('type');

        if ($type === null) {
            return null;
        }

        return new CategoryProcedureTypeEnum(\strtolower($type));
    }

    /**
     * @return mixed[]
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'description' => 'string',
            'type' => 'string',
        ];
    }
}
