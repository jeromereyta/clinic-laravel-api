<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Entities\AbstractEntity;
use App\Database\Schemas\CategoryProcedureSchema;
use App\Enum\CategoryProcedureTypeEnum;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * @method \App\Database\Entities\UserGuest getCreatedBy()
 * @method null|\App\Database\Entities\UserGuest getUpdatedBy()
 * @ORM\Entity()
 * @ORM\Table(
 *     name="category_procedures"
 * )
 */
class CategoryProcedure extends AbstractEntity
{
    use CategoryProcedureSchema;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Database\Entities\Procedure",
     *     mappedBy="categoryProcedure",
     *     cascade={"persist"}
     * )
     */
    protected Collection $createdProcedures;

    public function getCreatedAt(): ?DateTimeInterface
    {
        return null;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return null;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

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

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    protected function doGetRules(): array
    {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'type' => \sprintf('required|string|%s', $this->inRuleString(CategoryProcedureTypeEnum::toArray())),
        ];
    }

    protected function doToArray(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'type' => $this->getType(),
        ];
    }

    protected function getIdProperty(): string
    {
        return 'id';
    }
}
