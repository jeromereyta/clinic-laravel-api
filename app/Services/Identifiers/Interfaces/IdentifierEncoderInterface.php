<?php

declare(strict_types=1);

namespace App\Services\Identifiers\Interfaces;

interface IdentifierEncoderInterface
{
    /**
     * Decode an obfuscated value to a local identifier
     */
    public function decode(int $identifier): int;

    /**
     * Encode a local identifer into an obfuscated value
     */
    public function encode(int $identifier): int;
}
