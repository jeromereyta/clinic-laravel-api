<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);


// $app->register(\EonX\EasyCore\Bridge\Laravel\Providers\EasyCoreServiceProvider::class);

// $app->register(\EonX\EasyPagination\Bridge\Laravel\Providers\StartSizeInQueryEasyPagination Provider::class);

$app->bind(\Illuminate\Validation\PresenceVerifierInterface::class, \LaravelDoctrine\ORM\Validation\DoctrinePresenceVerifier::class);

$app->register(App\Providers\AuthServiceProvider::class);

$app->register(\LaravelDoctrine\Extensions\GedmoExtensionsServiceProvider::class);

$app->register(\EoneoPay\Externals\Bridge\Laravel\Providers\OrmServiceProvider::class);

$app->register(\App\Providers\FactoryServiceProvider::class);

$app->register(\App\Providers\PatientServiceProvider::class);

$app->register(\App\Providers\RepositoryProvider::class);

$app->register(\App\Providers\IdentifierServiceProvider::class);
/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

return $app;
