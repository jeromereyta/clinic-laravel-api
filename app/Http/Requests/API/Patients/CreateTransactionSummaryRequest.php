<?php

namespace App\Http\Requests\API\Patients;

use App\Http\Requests\BaseRequest;

final class CreateTransactionSummaryRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getRemarks(): ?string {
        return $this->getString('remarks') ?? null;
    }

    public function getPatientVisitId(): int {
        return $this->getInt('patient_visit_id');
    }

    public function getPaymentMethod(): string {
        return $this->getString('payment_method');
    }

    public function getTotalAmount(): string {
        return $this->getString('total_amount');
    }

    public function rules(): array
    {
        return [
            'remarks' => 'string',
            'total_amount' => 'required|string',
            'patient_visit_id' => 'required|integer',
            'payment_method' => 'required|string',
        ];
    }
}
