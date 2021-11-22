<?php

declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Entities\AbstractEntity;
use App\Database\Schemas\CategoryProcedureSchema;
use App\Database\Schemas\FileTypeSchema;
use App\Enum\CategoryProcedureTypeEnum;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="file_types"
 * )
 */
class FileType extends AbstractEntity
{
    use FileTypeSchema;

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
            'type' => 'required|string',
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
