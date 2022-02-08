<?php

namespace App\Http\Requests\API\PatientVisits;

use App\Http\Requests\BaseRequest;

final class AddPackageProcedureRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function getPatientVisitId(): int {
        return $this->getInt('patient_visit_id');
    }

    public function getPackageId(): int {
        return $this->getInt('package_id');
    }

    public function rules(): array
    {
        return [
            'patient_visit_id' => 'required|integer|exists:App\Database\Entities\PatientVisit,id',
            'package_id' => 'required|integer|exists:App\Database\Entities\Package,id',
        ];
    }
}
