<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Exports\PatientsExport;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Resources\Patients\PatientResource;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class PatientsExportCSVController extends AbstractAPIController
{
    private PatientRepositoryInterface $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository) {
        $this->patientRepository = $patientRepository;
    }

    public function __invoke(Request $request): BinaryFileResponse
    {
        $patients = $this->patientRepository->all();

        $results = [];

        foreach ($patients as $patient) {
            $resource = new PatientResource($patient);

            $results[] = json_decode($resource->toJson());
        }

        return Excel::download(new PatientsExport($results), 'patients.xlsx');
    }
}
