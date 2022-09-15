<?php

declare(strict_types=1);

use App\Domain\Project\Repository\ProjectRepositoryInterface;
use App\Infrastructure\Project\ApiPlatform\State\Provider\ProjectCrudProvider;
use App\Infrastructure\Project\Doctrine\DoctrineProjectRepository;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\\Domain\\Project\\', __DIR__.'/../../src/Domain/Project');
    $services->load('App\\Application\\Project\\', __DIR__.'/../../src/Application/Project');
    $services->load('App\\Infrastructure\\Project\\', __DIR__.'/../../src/Infrastructure/Project');

    // providers
    $services->set(ProjectCrudProvider::class)
        ->autoconfigure(false)
        ->tag('api_platform.state_provider', ['priority' => 0]);

    // repositories
    $services->set(ProjectRepositoryInterface::class)
        ->class(DoctrineProjectRepository::class);
};
