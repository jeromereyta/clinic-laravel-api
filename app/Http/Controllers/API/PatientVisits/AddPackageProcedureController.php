<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\PatientVisits;

use App\Database\Entities\User;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\PatientVisits\AddPackageProcedureRequest;
use App\Repositories\Interfaces\PackageProcedureRepositoryInterface;
use App\Repositories\Interfaces\PackageRepositoryInterface;
use App\Repositories\Interfaces\PatientProcedureRepositoryInterface;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Repositories\Interfaces\UserGuestRepositoryInterface;
use App\Services\PatientService\Resources\CreatePatientProcedureResource;
use Symfony\Component\HttpFoundation\Response;

final class AddPackageProcedureController extends AbstractAPIController
{
    private PackageRepositoryInterface $packageRepository;

    private PatientProcedureRepositoryInterface $patientProcedureRepository;

    private PatientVisitRepositoryInterface $patientVisitRepository;

    private UserGuestRepositoryInterface $userGuestRepository;

    public function __construct(
        PackageRepositoryInterface $packageRepository,
        PatientProcedureRepositoryInterface $patientProcedureRepository,
        PatientVisitRepositoryInterface $patientVisitRepository,
        UserGuestRepositoryInterface $userGuestRepository
    ) {
        $this->packageRepository = $packageRepository;
        $this->patientProcedureRepository = $patientProcedureRepository;
        $this->patientVisitRepository = $patientVisitRepository;
        $this->userGuestRepository = $userGuestRepository;
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function __invoke(AddPackageProcedureRequest $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        if ($user === null) {
            return $this->respondForbidden();
        }

        $userGuest = $this->userGuestRepository->findByUser($user);

        if ($userGuest === null) {
            return $this->respondUnprocessable([
                'message' => 'User not found',
            ]);
        }

        $package = $this->packageRepository->findById($request->getPackageId());

        if ($package === null) {
            return $this->respondNotFound([
                'message' => "Package Not Found.",
            ]);
        }


        $patientVisit = $this->patientVisitRepository->findByPatientVisit($request->getPatientVisitId());

        if ($patientVisit === null) {
            return $this->respondNotFound([
                'message' => 'Patient visit not found',
            ]);
        }

        try {
            $firstPackageProcedure = $package->getPackageProcedures()->first();

            $existingPackage = $this->patientProcedureRepository->findByPackageProcedureAndPatientVisit(
                $patientVisit,
                $firstPackageProcedure
            );

            if ($existingPackage !== null) {
                return $this->respondError(
                    'Package is already added',
                    Response::HTTP_CONFLICT
                );
            }

            $packageProcedures = $package->getPackageProcedures();

            $this->patientProcedureRepository->createPatientProceduresByPackage(new CreatePatientProcedureResource([
                'createdBy' => $userGuest,
                'description' => '',
                'procedures' => [],
                'packageProcedures' => $packageProcedures,
                'patientVisit' => $patientVisit,
            ]));

            return $this->respondNoContent();
        } catch (\Throwable $throwable) {
            return $this->respondError($throwable->getMessage());
        }
    }
}
