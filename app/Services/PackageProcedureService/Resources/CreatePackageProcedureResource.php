<?php

declare(strict_types=1);

namespace App\Services\PackageProcedureService\Resources;

use App\Database\Entities\Package;
use App\Database\Entities\Procedure;
use Spatie\DataTransferObject\DataTransferObject;

final class CreatePackageProcedureResource extends DataTransferObject
{
    public Package $package;

    public string $price;

    public Procedure $procedure;

    public function getPackage(): Package
    {
        return $this->package;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function getProcedure(): Procedure
    {
        return $this->procedure;
    }

    public function setPackage(Package $package): self
    {
        $this->package = $package;

        return $this;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function setProcedure(Procedure $procedure): self
    {
        $this->procedure = $procedure;

        return $this;
    }
}
