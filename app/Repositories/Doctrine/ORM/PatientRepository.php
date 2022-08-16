<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\Patient;
use App\Database\Entities\PatientVisit;
use App\Database\Entities\User;
use App\Database\Entities\UserGuest;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Services\PatientService\Resources\CreatePatientResource;
use Carbon\Carbon;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

final class PatientRepository extends AbstractRepository implements PatientRepositoryInterface
{
    /**
     * @return mixed[]
     */
    public function all(): array
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('p')
            ->from($this->getEntityClass(), 'p')
            ->orderBy('p.createdAt','desc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function create(CreatePatientResource $resource): Patient
    {
        $patient = new Patient();

        $patient->fill([
            'active' => $resource->getActive(),
            'barangay' => $resource->getBarangay(),
            'birthDate' => $resource->getBirthDate(),
            'city' => $resource->getCity(),
            'civilStatus' => $resource->getCivilStatus(),
            'country' => $resource->getCountry(),
            'createdBy' => $resource->getCreatedBy(),
            'email' => $resource->getEmail(),
            'gender' => $resource->getGender(),
            'name' => $resource->getName(),
            'firstName' => $resource->getFirstName(),
            'middleName' => $resource->getMiddleName(),
            'lastName' => $resource->getLastName(),
            'patientCode' => $resource->getPatientCode(),
            'phoneNumber' => $resource->getPhoneNumber(),
            'mobileNumber' => $resource->getMobileNumber(),
            'profilePicture' => $resource->getProfilePicture(),
            'province' => $resource->getProvince(),
            'streetAddress' => $resource->getStreetAddress(),
            'updatedBy' => $resource->getCreatedBy(),
            'updatedAt' => new Carbon(),
        ]);

        $this->entityManager->persist($patient);
        $this->entityManager->flush();

        return $patient;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findByFirstAndLastName(string $firstName, string $lastName): ?Patient
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        try {
            return $queryBuilder->select('p')
                ->from($this->getEntityClass(), 'p')
                ->where('p.firstName = :firstName')
                ->setParameter('firstName', $firstName)
                ->andWhere('p.lastName = :lastName')
                ->setParameter('lastName', $lastName)
                ->getQuery()
                ->getSingleResult();
        } catch (\Throwable $exception) {
            return null;
        }
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function findByPatientCode(string $patientCode): ?Patient
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        return $queryBuilder->select('p')
            ->from($this->getEntityClass(), 'p')
            ->where('p.patientCode = :patientCode')
            ->setParameters([
                'patientCode' => $patientCode,
            ])
            ->getQuery()
            ->getSingleResult();
    }

    public function findLatestId(): ?string
    {
        $queryBuilder = $this->manager->createQueryBuilder();

        $expr = $queryBuilder->expr();

        try {
            return (string) $queryBuilder
                ->select($expr->max('p.id'))
                ->from($this->getEntityClass(), 'p')
                ->getQuery()
                ->getSingleScalarResult() ?? "0";
        } catch (NoResultException | NonUniqueResultException $e) {
            return null;
        }
    }


    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updatePatientProfile(Patient $patient, string $profilePicture): Patient
    {
        $patient->setProfilePicture($profilePicture);

        $this->entityManager->persist($patient);
        $this->entityManager->flush();

        return $patient;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function updatePatient(Patient $patient, CreatePatientResource $resource): Patient
    {
        $patient
            ->setName($resource->getName())
            ->setFirstName($resource->getFirstName())
            ->setMiddleName($resource->getMiddleName())
            ->setLastName($resource->getLastName())
            ->setBarangay($resource->getBarangay())
            ->setBirthDate($resource->getBirthDate())
            ->setCity($resource->getCity())
            ->setCivilStatus($resource->getCivilStatus())
            ->setEmail($resource->getEmail())
            ->setGender($resource->getGender())
            ->setPhoneNumber($resource->getPhoneNumber())
            ->setMobileNumber($resource->getMobileNumber())
            ->setProvince($resource->getProvince())
            ->setStreetAddress($resource->getStreetAddress())
            ->setUpdatedAt(new Carbon());

        if ($patient->getName() !== $resource->getName()) {
            $patient->setName($resource->getName());
        }

        $this->entityManager->persist($patient);
        $this->entityManager->flush();

        return $patient;
    }

    protected function getEntityClass(): string
    {
        return Patient::class;
    }
}
