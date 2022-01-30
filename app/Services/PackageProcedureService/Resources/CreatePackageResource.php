<?php

declare(strict_types=1);

namespace App\Services\PackageProcedureService\Resources;

use Spatie\DataTransferObject\DataTransferObject;

final class CreatePackageResource extends DataTransferObject
{
    public string $name;

    public string $description;

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
