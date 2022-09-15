<?php

declare(strict_types=1);

namespace App\Application\Project\Command;

use App\Application\Shared\Command\CommandHandlerInterface;
use App\Domain\Project\Model\Project;
use App\Domain\Project\Repository\ProjectRepositoryInterface;

final class UpdateProjectCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    public function __invoke(UpdateProjectCommand $command): Project
    {
        $project = $this->projectRepository->ofId($command->id);

        $project->title = $command->title ?? $project->title;
        $project->excerpt = $command->excerpt ?? $project->excerpt;
        $project->description = $command->description ?? $project->description;
        $project->slug = $command->slug ?? $project->slug;
        $project->isPublished = $command->isPublished ?? $project->isPublished;
        $project->url = $command->url ?? $project->url;
        $project->photoFilename = $command->photoFilename ?? $project->photoFilename;
        $project->createdAt = $command->createdAt ?? $project->createdAt;
        $project->updatedAt = $command->updatedAt ?? $project->updatedAt;

        $this->projectRepository->remove($project);
        $this->projectRepository->add($project);

        return $project;
    }
}
