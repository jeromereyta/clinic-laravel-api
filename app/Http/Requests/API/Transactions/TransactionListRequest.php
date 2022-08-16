<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Transactions;

use App\Http\Requests\BaseRequest;
use Carbon\Carbon;

final class TransactionListRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getFrom(): ?string
    {
        return $this->getString('from') ?? null;
    }


    public function getTo(): ?string    {
        return $this->getString('to') ?? null;
    }

    public function rules(): array
    {
        return [
            'from' => 'date',
            'to' => 'date'
        ];
    }
}
