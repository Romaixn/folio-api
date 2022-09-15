<?php

declare(strict_types=1);

namespace App\Application\Project\Query;

use App\Application\Shared\Query\QueryInterface;

final class FindProjectQuery implements QueryInterface
{
    public function __construct(
        public readonly string $slug,
    ) {
    }
}
