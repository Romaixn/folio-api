<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\ApiPlatform\State\Processor;

use Webmozart\Assert\Assert;
use Symfony\Component\Uid\Uuid;
use ApiPlatform\Metadata\Operation;
use App\Domain\Project\Model\Project;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Metadata\DeleteOperationInterface;
use App\Application\Shared\Command\CommandBusInterface;
use App\Application\Project\Command\CreateProjectCommand;
use App\Application\Project\Command\DeleteProjectCommand;
use App\Application\Project\Command\UpdateProjectCommand;
use App\Infrastructure\Project\ApiPlatform\Resource\ProjectResource;

final class ProjectCrudProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        Assert::isInstanceOf($data, ProjectResource::class);

        if ($operation instanceof DeleteOperationInterface) {
            $this->commandBus->dispatch(new DeleteProjectCommand(Uuid::fromString($uriVariables['id'])));

            return null;
        }

        $command = !isset($uriVariables['id'])
            ? new CreateProjectCommand($data->title, $data->excerpt, $data->description, $data->isPublished, $data->url, $data->photoFilename)
            : new UpdateProjectCommand(Uuid::fromString($uriVariables['id']), $data->title, $data->excerpt, $data->description, $data->isPublished, $data->url, $data->photoFilename)
        ;

        /** @var Project $model */
        $model = $this->commandBus->dispatch($command);

        return ProjectResource::fromModel($model);
    }
}
