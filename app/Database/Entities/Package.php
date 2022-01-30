<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Schemas\PackageSchema;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="packages"
 * )
 */
class Package extends AbstractEntity
{
    use PackageSchema;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Database\Entities\PackageProcedure",
     *     mappedBy="package",
     *     cascade={"persist"}
     * )
     */
    protected Collection $packageProcedures;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
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

    protected function doGetRules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
        ];
    }

    protected function doToArray(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
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
