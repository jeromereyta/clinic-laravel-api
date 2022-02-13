<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\Identifiers\IdentifierEncoder;
use App\Services\Identifiers\Interfaces\IdentifierEncoderInterface;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Optimus\Optimus;

final class IdentifierServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Optimus::class, static function () {
            $optimus = \config('optimus');

            return new Optimus($optimus['prime'], $optimus['inverse'], $optimus['random']);
        });

        $this->app->bind(IdentifierEncoderInterface::class, IdentifierEncoder::class);
    }
}
