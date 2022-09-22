<?php

declare(strict_types=1);

namespace App\Project\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Project\Application\Command\CreateProjectCommand;
use App\Project\Domain\Model\Project;
use App\Project\Domain\ValueObject\ProjectContent;
use App\Project\Domain\ValueObject\ProjectExcerpt;
use App\Project\Domain\ValueObject\ProjectTitle;
use App\Project\Infrastructure\ApiPlatform\Resource\ProjectResource;
use App\Shared\Application\Command\CommandBusInterface;
use Webmozart\Assert\Assert;

final class CreateProjectProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param mixed $data
     *
     * @return ProjectResource
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        Assert::isInstanceOf($data, ProjectResource::class);

        Assert::notNull($data->title);
        Assert::notNull($data->excerpt);
        Assert::notNull($data->content);

        $command = new CreateProjectCommand(
            new ProjectTitle($data->title),
            new ProjectExcerpt($data->excerpt),
            new ProjectContent($data->content),
        );

        /** @var Project $model */
        $model = $this->commandBus->dispatch($command);

        return ProjectResource::fromModel($model);
    }
}
