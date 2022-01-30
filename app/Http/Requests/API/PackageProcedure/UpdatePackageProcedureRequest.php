<?php

namespace App\Http\Requests\API\PackageProcedure;

use App\Http\Requests\BaseRequest;

final class UpdatePackageProcedureRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getPrice(): string
    {
        return $this->getString('price');
    }

    public function rules(): array
    {
        return [
            'price' => 'required|string',
        ];
    }
}
