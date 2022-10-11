<?php

declare(strict_types=1);

use App\Contact\Service\SendMail;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\Contact\\', __DIR__.'/../../src/Contact');

    $services->set(SendMail::class)
        ->arg('$adminEmail', '%env(ADMIN_EMAIL)%');
};
