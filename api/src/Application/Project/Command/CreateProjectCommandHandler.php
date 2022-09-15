<?php

declare(strict_types=1);

namespace App\Application\Project\Command;

use App\Application\Shared\Command\CommandHandlerInterface;
use App\Domain\Project\Model\Project;
use App\Domain\Project\Repository\ProjectRepositoryInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

final class CreateProjectCommandHandler implements CommandHandlerInterface
{
    public function __construct(private ProjectRepositoryInterface $projectRepository, private SluggerInterface $slugger)
    {
    }

    public function __invoke(CreateProjectCommand $command): Project
    {
        if (!$command->slug || '-' === $command->slug) {
            $command->slug = (string) $this->slugger->slug((string) $command->title)->lower();
        }
        $project = new Project($command->title, $command->excerpt, $command->description, $command->slug, $command->isPublished, $command->url, $command->photoFilename);

        $this->projectRepository->add($project);

        return $project;
    }
}
