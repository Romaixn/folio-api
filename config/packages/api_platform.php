<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Webmozart\Assert\InvalidArgumentException;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('api_platform', [
        'title' => 'rherault API',
        'version' => '2.0.0',
        'show_webby' => false,
        'openapi' => [
            'contact' => [
                'name' =>  'Romain Herault',
                'url' => 'https://rherault.fr',
                'email' => 'romain@rherault.fr'
            ]
        ],
        'mapping' => [
            'paths' => [
                '%kernel.project_dir%/src/Infrastructure/Project/ApiPlatform/Resource/',
            ],
        ],
        'formats' => [
            'jsonld' => [ 'application/ld+json' ],
            'json' => [ 'application/json' ],
            'html' => [ 'text/html' ]
        ],
        'patch_formats' => [
            'jsonld' => [ 'application/ld+json' ],
            'jsonapi' => [ 'application/vnd.api+json' ],
            'json' => ['application/merge-patch+json'],
        ],
        'swagger' => [
            'versions' => [3],
        ],
        'error_formats' => [
            'jsonproblem' => [ 'application/problem+json' ],
            'jsonld' => [ 'application/ld+json' ],
            'jsonapi' => [ 'application/vnd.api+json' ]
        ],
        'eager_loading' => [
            'fetch_partial' => true,
            'force_eager' => false
        ],
        'defaults' => [
            'stateless' => false,
            'cache_headers' => [
                'vary' => [ 'Content-Type', 'Authorization', 'Origin' ]
            ]
        ]
    ]);
};
