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
            ],
        ],
        'patch_formats' => [
            'json' => ['application/merge-patch+json'],
        ],
        'swagger' => [
            'versions' => [3],
        ],
        'exception_to_status' => [
            // TODO
            // We must trigger the API Platform validator before the data transforming.
            // Let's create an API Platform PR to update the AbstractItemNormalizer.
            // In that way, this exception won't be raised anymore as payload will be validated (see DiscountBookPayload).
            InvalidArgumentException::class => 422,
        ],
        'eager_loading' => [
            'fetch_partial' => true,
            'force_eager' => false,
        ],
        'defaults' => [
            'stateless' => false,
            'cache_headers' => [
                'vary' => ['Content-Type', 'Authorization', 'Origin'],
            ],
        ],
    ]);
};
