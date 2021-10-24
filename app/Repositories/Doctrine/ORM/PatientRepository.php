<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine\ORM;

use App\Database\Entities\Patient;
use App\Database\Entities\User;
use App\Database\Entities\UserGuest;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Services\PatientService\Resources\CreatePatientResource;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

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
            ->getQuery()
            ->getResult();
    }

    /**
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(CreatePatientResource $resource): Patient
    {
        $patient = new Patient();

        $patient->fill([
            'active' => $resource->getActive(),
            'age' => $resource->getAge(),
            'barangay' => $resource->getBarangay(),
            'birthDate' => $resource->getBirthDate(),
            'city' => $resource->getCity(),
            'civilStatus' => $resource->getCivilStatus(),
            'country' => $resource->getCountry(),
            'createdBy' => $resource->getCreatedBy(),
            'email' => $resource->getEmail(),
            'gender' => $resource->getGender(),
            'name' => $resource->getName(),
            'patientCode' => $resource->getPatientCode(),
            'phoneNumber' => $resource->getPhoneNumber(),
            'profilePicture' => $resource->getProfilePicture(),
            'province' => $resource->getProvince(),
            'streetAddress' => $resource->getStreetAddress(),
            'updatedBy' => $resource->getCreatedBy(),
        ]);

        $this->entityManager->persist($patient);
        $this->entityManager->flush();

        return $patient;
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
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
            return $queryBuilder
                ->select($expr->max('p.id'))
                ->from($this->getEntityClass(), 'p')
                ->getQuery()
                ->getSingleScalarResult() ?? "1";
        } catch (NoResultException | NonUniqueResultException $e) {
            return null;
        }
    }

    protected function getEntityClass(): string
    {
        return Patient::class;
    }
}
