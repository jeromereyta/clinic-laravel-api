<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Patients\CreatePatientRequest;
use App\Http\Requests\API\Patients\CreatePatientVisitRequest;
use App\Http\Resources\Patients\PatientVisitResource;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Repositories\Interfaces\UserGuestRepositoryInterface;
use App\Services\Identifiers\Interfaces\IdentifierEncoderInterface;
use App\Services\PatientService\Interfaces\GeneratePatientCodeServiceInterface;
use App\Services\PatientService\Resources\CreatePatientResource;
use App\Services\PatientService\Resources\CreatePatientVisitResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreatePatientVisitsController extends AbstractAPIController
{
    private PatientRepositoryInterface $patientRepository;

    private PatientVisitRepositoryInterface $patientVisitRepository;

    private UserGuestRepositoryInterface $userGuestRepository;
    private IdentifierEncoderInterface $identifierEncoder;

    public function __construct(
        IdentifierEncoderInterface $identifierEncoder,
        PatientRepositoryInterface $patientRepository,
        PatientVisitRepositoryInterface $patientVisitRepository,
        GeneratePatientCodeServiceInterface $generatePatientCodeService,
        UserGuestRepositoryInterface $userGuestRepository
    ) {
        $this->identifierEncoder = $identifierEncoder;
        $this->patientRepository = $patientRepository;
        $this->patientVisitRepository = $patientVisitRepository;
        $this->userGuestRepository = $userGuestRepository;
    }

    public function __invoke(CreatePatientVisitRequest $request): JsonResource
    {
        /** @var \App\Database\Entities\User $user */
        $user = $this->getUser();

        if ($user === null) {
            return $this->respondForbidden();
        }

        $userGuest = $this->userGuestRepository->findByUser($user);

        if ($userGuest === null) {
            return $this->respondUnprocessable([
                'message' => 'User guest error',
            ]);
        }

        $patient = $this->patientRepository->findByPatientCode($request->getPatientCode());

        if ($patient === null) {
            return $this->respondNotFound([
                'message' => 'Patient not found',
            ]);
        }

        $patientVisit = $this->patientVisitRepository->create(new CreatePatientVisitResource([
            'attendingDoctor' => $request->getAttendingDoctor(),
            'createdBy' => $userGuest,
            'patientBp' => $request->getPatientBp(),
            'patient' => $patient,
            'patientHeight' => $request->getPatientHeight(),
            'patientWeight' => $request->getPatientWeight(),
            'remarks' => $request->getRemarks(),
        ]));

        return new PatientVisitResource($patientVisit, $this->identifierEncoder);
    }
}
