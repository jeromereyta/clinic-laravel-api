<?php

declare(strict_types=1);

namespace App\Services\Procedure\Resources;

use App\Database\Entities\CategoryProcedure;
use Spatie\DataTransferObject\DataTransferObject;

final class CreateProcedureResource extends DataTransferObject
{
    public bool $active;

    public CategoryProcedure $categoryProcedure;

    public string $name;

    public string $description;

    public string $price;

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
            return $this;
    }

    public function getCategoryProcedure(): CategoryProcedure
    {
        return $this->categoryProcedure;
    }

    public function setCategoryProcedure(CategoryProcedure $categoryProcedure): self
    {
        $this->categoryProcedure = $categoryProcedure;
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

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
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
}
