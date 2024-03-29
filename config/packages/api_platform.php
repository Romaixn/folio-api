<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Webmozart\Assert\InvalidArgumentException;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('api_platform', [
        'title' => 'rherault API',
        'version' => '2.0.0',
        'openapi' => [
            'contact' => [
                'name' => 'Romain Herault',
                'url' => 'https://rherault.fr',
                'email' => 'romain@rherault.fr',
            ],
        ],
        'mapping' => [
            'paths' => [
                '%kernel.project_dir%/src/Project/Infrastructure/ApiPlatform/Resource/',
                '%kernel.project_dir%/src/Contact/Entity/',
            ],
        ],
        'patch_formats' => [
            'json' => ['application/merge-patch+json'],
        ],
        'swagger' => [
            'versions' => [3],
        ],
        'exception_to_status' => [
            InvalidArgumentException::class => 422,
        ],
        'eager_loading' => [
            'fetch_partial' => true,
            'force_eager' => false,
        ],
        'defaults' => [
            'extra_properties' => [
                'standard_put' => true,
            ],
            'stateless' => false,
            'cache_headers' => [
                'vary' => ['Content-Type', 'Authorization', 'Origin'],
            ],
        ],
    ]);
};
