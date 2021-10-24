<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Patients\CreatePatientRequest;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Repositories\Interfaces\PatientVisitRepositoryInterface;
use App\Repositories\Interfaces\UserGuestRepositoryInterface;
use App\Services\PatientService\Interfaces\GeneratePatientCodeServiceInterface;
use App\Services\PatientService\Resources\CreatePatientResource;
use App\Services\PatientService\Resources\CreatePatientVisitResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

final class CreatePatientController extends AbstractAPIController
{
    private GeneratePatientCodeServiceInterface $generatePatientCodeService;

    private PatientRepositoryInterface $patientRepository;

    private PatientVisitRepositoryInterface $patientVisitRepository;

    private UserGuestRepositoryInterface $userGuestRepository;

    public function __construct(
        PatientRepositoryInterface $patientRepository,
        PatientVisitRepositoryInterface $patientVisitRepository,
        GeneratePatientCodeServiceInterface $generatePatientCodeService,
        UserGuestRepositoryInterface $userGuestRepository
    ) {
        $this->patientRepository = $patientRepository;
        $this->patientVisitRepository = $patientVisitRepository;
        $this->generatePatientCodeService = $generatePatientCodeService;
        $this->userGuestRepository = $userGuestRepository;
    }

    public function __invoke(CreatePatientRequest $request): JsonResource
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

        $patientCode = $this->generatePatientCodeService->generate($this->patientRepository->findLatestId());

        $patient = $this->patientRepository->create( new CreatePatientResource([
            'active' => true,
            'age' => '0',
            'barangay' => $request->getBarangay(),
            'birthDate' => $request->getBirthDate(),
            'civilStatus' => $request->getCivilStatus(),
            'city' => $request->getCity(),
            'createdBy' => $userGuest,
            'email' => $request->getEmail(),
            'gender' => $request->getGender(),
            'name' => $request->getName(),
            'patientCode' => $patientCode,
            'phoneNumber' => $request->getPhoneNumber(),
            'profilePicture' => $request->getProfilePicture(),
            'province' => $request->getProvince(),
            'streetAddress' => $request->getStreetAddress(),
            'updatedBy' => $userGuest,
        ]));

        $patientVisit = $this->patientVisitRepository->create(new CreatePatientVisitResource([
            'attendingDoctor' => $request->getAttendingDoctor(),
            'createdBy' => $userGuest,
            'patientBp' => $request->getPatientBp(),
            'patient' => $patient,
            'patientHeight' => $request->getPatientHeight(),
            'patientWeight' => $request->getPatientWeight(),
            'remarks' => $request->getRemarks(),
        ]));

        return new JsonResource([
            'Successfully created patient with patient visits',
        ]);
    }
}