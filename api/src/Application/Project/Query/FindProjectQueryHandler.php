<?php

declare(strict_types=1);

namespace App\Application\Project\Query;

use App\Application\Shared\Query\QueryHandlerInterface;
use App\Domain\Project\Model\Project;
use App\Domain\Project\Repository\ProjectRepositoryInterface;

final class FindProjectQueryHandler implements QueryHandlerInterface
{
    public function __construct(private ProjectRepositoryInterface $repository)
    {
    }

    public function __invoke(FindProjectQuery $query): ?Project
    {
        return $this->repository->ofSlug($query->slug);
    }
}
