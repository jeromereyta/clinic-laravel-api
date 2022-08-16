<?php

namespace App\Http\Requests\API\Patients;

use App\Http\Requests\BaseRequest;

final class CreatePatientProcedureRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getDescription(): ?string {
        return $this->getString('note') ?? ' ';
    }

    public function getPatientVisitId(): int {
        return $this->getInt('patient_visit_id');
    }

    /**
     * @return string[]
     */
    public function getProcedureIds(): array {
        return $this->get('procedure_ids');
    }

    public function rules(): array
    {
        return [
          'note' => 'string|nullable',
          'patient_visit_id' => 'required|integer',
          'procedure_ids' => 'required|array',
        ];
    }
}
