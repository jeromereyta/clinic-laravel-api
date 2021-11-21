<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\Patients;

use App\Http\Controllers\API\AbstractAPIController;
use App\Http\Requests\API\Patients\CreatePatientRequest;
use App\Http\Requests\API\Patients\UploadPatientProfileRequest;
use App\Http\Resources\Patients\PatientResource;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Services\PatientService\Interfaces\UploadPatientProfilePictureInterface;
use Illuminate\Http\Resources\Json\JsonResource;

final class UploadPatientProfileController extends AbstractAPIController
{
    private PatientRepositoryInterface $patientRepository;

    private UploadPatientProfilePictureInterface $uploadPatientProfilePicture;

    public function __construct(
        PatientRepositoryInterface $patientRepository,
        UploadPatientProfilePictureInterface $uploadPatientProfilePicture
    ) {
        $this->patientRepository = $patientRepository;
        $this->uploadPatientProfilePicture = $uploadPatientProfilePicture;
    }

    public function __invoke(UploadPatientProfileRequest $request): JsonResource
    {
        $image = $request->getImageFile();

        $patient = $this->patientRepository->findByPatientCode($request->getPatientCode());

        if ($patient === null) {
            return $this->respondNotFound(['message' => 'Patient not found']);
        }

        $imageObject = $this->uploadPatientProfilePicture->upload($image);

        $patient = $this->patientRepository->updatePatientProfile($patient, $imageObject['image_name']);

        return new PatientResource($patient);
    }
}
