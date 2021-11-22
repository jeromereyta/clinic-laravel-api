<?php

declare(strict_types=1);

namespace App\Services\FileUpload\Resources;

use Spatie\DataTransferObject\DataTransferObject;

final class CreateFileTypeResource extends DataTransferObject
{
    public string $name;

    public string $description;

    public string $type;

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
        return $this->type;
    }

    public function setType(string $type):self
    {
        $this->type = $type;

        return $this;
    }
}
