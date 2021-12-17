<?php

namespace App\Http\Requests\API\Queue;

use App\Enum\ProcedureQueueTypeEnum;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

final class UpdateProcedureQueueRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function isToMoveBack(): bool
    {
        $moveBack = $this->get('move_back' , false);

        return filter_var($moveBack, FILTER_VALIDATE_BOOLEAN);
    }

    public function getStatus(): string
    {
        return $this->getString('status');
    }

    public function getId(): int
    {
        return $this->getInt('id');
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
            'move_back' => '',
            'status' => [
                'required',
                'string',
                Rule::in(ProcedureQueueTypeEnum::toArray()),
            ],
            'remarks' => 'string',
            'id' => 'required',
        ];
    }
}
