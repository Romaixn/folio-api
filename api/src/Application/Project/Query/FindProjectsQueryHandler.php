<?php

declare(strict_types=1);

namespace App\Application\Project\Query;

use App\Application\Shared\Query\QueryHandlerInterface;
use App\Domain\Project\Repository\ProjectRepositoryInterface;

final class FindProjectsQueryHandler implements QueryHandlerInterface
{
    public function __construct(private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    public function __invoke(FindProjectsQuery $query): ProjectRepositoryInterface
    {
        $projectRepository = $this->projectRepository;

        if (null !== $query->page && null !== $query->itemsPerPage) {
            $projectRepository = $projectRepository->withPagination($query->page, $query->itemsPerPage);
        }

        return $projectRepository;
    }
}
