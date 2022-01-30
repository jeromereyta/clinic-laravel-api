<?php

namespace App\Http\Requests\API\PackageProcedure;

use App\Http\Requests\BaseRequest;

final class CreatePackageWithPackageProcedureRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getDescription(): ?string
    {
        return $this->getString('name') ?? null;
    }

    public function getName(): string
    {
        return $this->getString('name');
    }

    /**
     * @return mixed[]
     */
    public function getProcedures(): array
    {
        return $this->get('procedures');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'string',
            'procedures' => 'required|array',
            'procedures.*.id' => 'required',
            'procedures.*.price' => 'required|string',
        ];
    }
}
