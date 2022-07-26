<?php

declare(strict_types=1);

namespace App\Application\Project\Command;

use App\Application\Shared\Command\CommandHandlerInterface;
use App\Domain\Project\Model\Project;
use App\Domain\Project\Repository\ProjectRepositoryInterface;

final class CreateProjectCommandHandler implements CommandHandlerInterface
{
    public function __construct(private ProjectRepositoryInterface $projectRepository)
    {
    }

    public function __invoke(CreateProjectCommand $command): Project
    {
        $project = new Project($command->title, $command->excerpt, $command->description, $command->slug, $command->createdAt, $command->updatedAt, $command->state, $command->isPublished, $command->url, $command->photoFilename);

        $this->projectRepository->add($project);

        return $project;
    }
}
