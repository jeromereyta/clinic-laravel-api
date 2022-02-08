<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Entities\AbstractEntity;
use App\Database\Schemas\ProcedureSchema;
use DateTimeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method \App\Database\Entities\UserGuest getCreatedBy()
 * @method null|\App\Database\Entities\UserGuest getUpdatedBy()
 * @method null|\App\Database\Entities\PatientProcedure getPatientProcedure()
 *
 * @ORM\Entity()
 * @ORM\Table(
 *     name="procedures"
 * )
 */
class Procedure extends AbstractEntity
{
    use ProcedureSchema;

    /**
     * @ORM\ManyToOne(
     *     targetEntity="App\Database\Entities\CategoryProcedure",
     *     inversedBy="createdProcedures",
     *     cascade={"persist"}
     * )
     *
     * @ORM\JoinColumn(name="category_procedure_id", referencedColumnName="id")
     */
    protected CategoryProcedure $categoryProcedure;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Database\Entities\PatientProcedure",
     *     mappedBy="procedure",
     *     cascade={"persist"}
     * )
     */
    protected Collection $patientProcedures;

    /**
     * @ORM\OneToOne (
     *     targetEntity="App\Database\Entities\PackageProcedure",
     *     mappedBy="procedure",
     *     cascade={"persist"}
     * )
     */
    protected ?PackageProcedure $packageProcedure = null;

    public DateTimeInterface $createdAt;

    public DateTimeInterface $updatedAt;

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }

    public function setCategoryProcedure(CategoryProcedure $categoryProcedure): self
    {
        $this->categoryProcedure = $categoryProcedure;
        $this->categoryProcedureId = $categoryProcedure->getId();

        return $this;
    }

    public function getCategoryProcedureId(): int
    {
        return $this->categoryProcedure->getId();
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    protected function doGetRules(): array
    {
        return [
            'active' => 'required|bool',
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string',
            'categoryProcedure' => \sprintf('required|%s', $this->instanceOfRuleAsString(CategoryProcedure::class)),
        ];
    }

    protected function doToArray(): array
    {
        return [
            'active' => $this->isActive(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'category_procedure_id' => $this->getCategoryProcedureId(),
        ];
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
