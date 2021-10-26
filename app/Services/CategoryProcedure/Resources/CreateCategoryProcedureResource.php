<?php

declare(strict_types=1);

namespace App\Services\CategoryProcedure\Resources;

use App\Enum\CategoryProcedureTypeEnum;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateCategoryProcedureResource extends DataTransferObject
{
    public string $name;

    public string $description;

    public CategoryProcedureTypeEnum $type;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
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
        return $this->type->getValue();
    }

    public function setType(CategoryProcedureTypeEnum $categoryProcedureTypeEnum):self
    {
        $this->type = $categoryProcedureTypeEnum->getValue();
        return $this;
    }
}
