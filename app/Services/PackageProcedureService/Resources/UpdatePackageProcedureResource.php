<?php

declare(strict_types=1);

namespace App\Services\PackageProcedureService\Resources;

use App\Database\Entities\Package;
use App\Database\Entities\Procedure;
use Spatie\DataTransferObject\DataTransferObject;

final class UpdatePackageProcedureResource extends DataTransferObject
{
    public string $price;

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
