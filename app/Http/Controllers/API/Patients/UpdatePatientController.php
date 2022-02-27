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

        $existName = $this->patientRepository->findByFirstAndLastName($request->getFirstName(), $request->getLastName());

        if ($existName !== null) {
            return $this->respondUnprocessable([
                'message' => 'User first and last name already exist.',
            ]);
        }

        $name = \sprintf(
            '%s, %s %s',
            $request->getLastName(),
            $request->getMiddleName(),
            $request->getFirstName(),
        );

        $updateResource = new CreatePatientResource([
            'active' => true,
            'barangay' => $request->getBarangay(),
            'birthDate' => $request->getBirthDate(),
            'civilStatus' => $request->getCivilStatus(),
            'city' => $request->getCity(),
            'createdBy' => $userGuest,
            'email' => $request->getEmail(),
            'gender' => $request->getGender(),
            'name' => $name,
            'firstName' => $request->getFirstName(),
            'middleName' => $request->getMiddleName(),
            'lastName' => $request->getLastName(),
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
