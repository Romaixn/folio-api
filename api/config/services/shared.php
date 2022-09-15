<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\Domain\\Shared\\', __DIR__.'/../../src/Domain/Shared');
    $services->load('App\\Application\\Shared\\', __DIR__.'/../../src/Application/Shared');
    $services->load('App\\Infrastructure\\Shared\\', __DIR__.'/../../src/Infrastructure/Shared')
        ->exclude([__DIR__.'/../../src/Infrastructure/Shared/Kernel.php']);
};
