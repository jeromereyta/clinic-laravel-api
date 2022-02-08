<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PatientVisits;


use App\Http\Controllers\API\AbstractAPIController;
use App\Repositories\Interfaces\PatientProcedureRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

final class RemoveProcedureController extends AbstractAPIController
{
    private PatientProcedureRepositoryInterface $patientProcedureRepository;

    public function __construct(PatientProcedureRepositoryInterface $patientProcedureRepository) {
        $this->patientProcedureRepository = $patientProcedureRepository;
    }

    public function __invoke(int $id): JsonResource
    {
        try {
            $patientProcedure = $this->patientProcedureRepository->findById($id);

            $packageProcedure = $patientProcedure->getPackageProcedure();

            $isPackage = $packageProcedure !== null;

            if ($isPackage === false) {
                $this->patientProcedureRepository->deletePatientProcedure($patientProcedure);

                return $this->respondNoContent();
            }

            foreach ($packageProcedure->getPackage()->getPackageProcedures() as $packageProcedure) {
                $patientProcedureItem = $this->patientProcedureRepository->findByPackageProcedureAndPatientVisit(
                    $patientProcedure->getPatientVisit(),
                    $packageProcedure
                );

                $this->patientProcedureRepository->deletePatientProcedure($patientProcedureItem);
            }

            return $this->respondNoContent();
        } catch (Throwable $exception) {
            return $this->respondError($exception->getMessage());
        }
    }
}
