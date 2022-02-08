<?php

declare(strict_types=1);

namespace App\Http\Resources\Packages;

use App\Http\Resources\Resource;

final class PackagesResource extends Resource
{
    /**
     * @param mixed[] $packages
     */
    public function __construct(array $packages)
    {
        parent::__construct($packages);
    }

    /**
     * Return response for this resource.
     *
     * @return mixed[]
     */
    protected function getResponse(): array
    {
        $results = [];

        foreach ($this->resource as $package) {
            $results[] = new PackageResource($package);
        }

        return $results;
    }
}
