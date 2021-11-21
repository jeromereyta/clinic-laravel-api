<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Database\Entities\User;
use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Patients\UpdatePatientRequest;
use App\Http\Resources\Patients\PatientResource;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Repositories\Interfaces\UserGuestRepositoryInterface;
use App\Services\PatientService\Resources\CreatePatientResource;
use Illuminate\Http\Resources\Json\JsonResource;

final class UpdatePatientController extends AbstractAPIController
{
    private PatientRepositoryInterface $patientRepository;

    private UserGuestRepositoryInterface $userGuestRepository;

    public function __construct(
        PatientRepositoryInterface $patientRepository,
        UserGuestRepositoryInterface $userGuestRepository
    ) {
        $this->patientRepository = $patientRepository;
        $this->userGuestRepository = $userGuestRepository;
    }

    public function __invoke(UpdatePatientRequest $request, string $patientCode): JsonResource
    {
        /** @var User $user */
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

        $patient = $this->patientRepository->findByPatientCode($patientCode);

        if ($patient === null) {
            return $this->respondNotFound(['message' => 'Patient not found']);
        }

        $updateResource =  new CreatePatientResource([
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
            'mobileNumber' => $request->getMobileNumber(),
            'profilePicture' => '',
            'province' => $request->getProvince(),
            'streetAddress' => $request->getStreetAddress(),
            'updatedBy' => $userGuest,
        ]);


        $patient = $this->patientRepository->updatePatient($patient, $updateResource);

        return new PatientResource($patient);
    }
}
