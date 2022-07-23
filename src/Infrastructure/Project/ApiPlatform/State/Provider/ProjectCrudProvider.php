<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\ApiPlatform\State\Provider;

use ApiPlatform\Metadata\Operation;
use App\Domain\Project\Model\Project;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\State\Pagination\Pagination;
use App\Application\Project\Query\FindProjectQuery;
use App\Application\Shared\Query\QueryBusInterface;
use App\Application\Project\Query\FindProjectsQuery;
use ApiPlatform\Metadata\CollectionOperationInterface;
use App\Infrastructure\Shared\ApiPlatform\State\Paginator;
use App\Domain\Project\Repository\ProjectRepositoryInterface;
use App\Infrastructure\Project\ApiPlatform\Resource\ProjectResource;

final class ProjectCrudProvider implements ProviderInterface
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private Pagination $pagination,
    ) {
    }

    /**
     * @return ProjectResource|Paginator<ProjectResource>|array<ProjectResource>
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if (!$operation instanceof CollectionOperationInterface) {
            /** @var Project|null $model */
            $model = $this->queryBus->ask(new FindProjectQuery($uriVariables['slug']));

            return null !== $model ? ProjectResource::fromModel($model) : null;
        }

        $category = $context['filters']['category'] ?? null;
        $offset = $limit = null;

        if ($this->pagination->isEnabled($operation, $context)) {
            $offset = $this->pagination->getPage($context);
            $limit = $this->pagination->getLimit($operation, $context);
        }

        /** @var ProjectRepositoryInterface $models */
        $models = $this->queryBus->ask(new FindProjectsQuery($category, $offset, $limit));

        $resources = [];
        foreach ($models as $model) {
            $resources[] = ProjectResource::fromModel($model);
        }

        if (null !== $paginator = $models->paginator()) {
            $resources = new Paginator(
                $resources,
                (float) $paginator->getCurrentPage(),
                (float) $paginator->getItemsPerPage(),
                (float) $paginator->getLastPage(),
                (float) $paginator->getTotalItems(),
            );
        }

        return $resources;
    }
}
