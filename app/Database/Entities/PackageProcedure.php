<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Schemas\PackageProcedureSchema;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="package_procedures"
 * )
 */
class PackageProcedure extends AbstractEntity
{
    use PackageProcedureSchema;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Database\Entities\PatientProcedure",
     *     mappedBy="packageProcedure",
     *     cascade={"persist"}
     * )
     */
    protected PersistentCollection $patientProcedures;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\Package",
     *     inversedBy="package",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="package_id", referencedColumnName="id")
     */
    protected Package $package;

    /**
     * @ORM\OneToOne (
     *     targetEntity="App\Database\Entities\Procedure",
     *     inversedBy="packageProcedure",
     *     cascade={"persist"}
     * )
     * @ORM\JoinColumn(name="procedure_id", referencedColumnName="id")
     */
    public Procedure $procedure;

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getDeletedAt(): ?DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function getPackage(): Package
    {
        return $this->package;
    }

    public function getPackageId(): int
    {
        return $this->packageId;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getProcedure(): Procedure
    {
        return $this->procedure;
    }

    public function getProcedureId(): int
    {
        return $this->procedureId;
    }

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setDeletedAt(DateTimeInterface $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function setPackage(Package $package): self
    {
        $this->packageId = $package->getId();
        $this->package = $package;

        return $this;
    }

    public function setPackageId(int $packageId): self
    {
        $this->packageId = $packageId;

        return $this;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function setProcedure(Procedure $procedure): self
    {
        $this->procedureId = (int) $procedure->getId();
        $this->procedure = $procedure;

        return $this;
    }

    public function setProcedureId(int $procedureId): self
    {
        $this->procedureId = $procedureId;

        return $this;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
            'price' => 'required|string',
            'package' => \sprintf('required|%s', $this->instanceOfRuleAsString(Package::class)),
            'procedure' => \sprintf('required|%s', $this->instanceOfRuleAsString(Procedure::class)),
        ];
    }

    /**
     * @return mixed[]
     */
    protected function doToArray(): array
    {
        return [
            'package' => $this->getPackage(),
            'procedure' => $this->getProcedure(),
            'createdAt' => $this->getCreatedAt(),
            'deletedAt' => $this->getDeletedAt(),
            'updatedAt' => $this->getUpdatedAt(),
        ];
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
