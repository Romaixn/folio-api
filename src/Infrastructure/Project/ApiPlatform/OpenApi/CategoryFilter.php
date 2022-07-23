<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\ApiPlatform\OpenApi;

use ApiPlatform\Api\FilterInterface;
use Symfony\Component\PropertyInfo\Type;

final class CategoryFilter implements FilterInterface
{
    /**
     * @return array<mixed>
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            'category' => [
                'property' => 'category',
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
            ],
        ];
    }
}
