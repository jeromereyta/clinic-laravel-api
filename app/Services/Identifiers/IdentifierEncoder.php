<?php

declare(strict_types=1);

namespace App\Services\Identifiers;

use Jenssegers\Optimus\Optimus;
use App\Services\Identifiers\Interfaces\IdentifierEncoderInterface;

final class IdentifierEncoder implements IdentifierEncoderInterface
{
    private Optimus $optimus;

    public function __construct(Optimus $optimus)
    {
        $this->optimus = $optimus;
    }

    /**
     * Decode an obfuscated value to a local identifier
     */
    public function decode(int $identifier): int
    {
        return $this->optimus->decode($identifier);
    }

    /**
     * Encode a local identifer into an obfuscated value
     */
    public function encode(int $identifier): int
    {
        return $this->optimus->encode($identifier);
    }
}
