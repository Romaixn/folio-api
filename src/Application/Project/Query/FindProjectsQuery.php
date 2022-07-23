<?php

declare(strict_types=1);

namespace App\Application\Project\Query;

use App\Application\Shared\Query\QueryInterface;

final class FindProjectsQuery implements QueryInterface
{
    public function __construct(
        public readonly ?string $category = null,
        public readonly ?int $page = null,
        public readonly ?int $itemsPerPage = null,
    ) {
    }
}
