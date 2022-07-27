<?php

declare(strict_types=1);

namespace App\Application\Project\Command;

use App\Application\Shared\Command\CommandHandlerInterface;
use App\Domain\Project\Repository\ProjectRepositoryInterface;

final class DeleteProjectCommandHandler implements CommandHandlerInterface
{
    public function __construct(private readonly ProjectRepositoryInterface $projectRepository)
    {
    }

    public function __invoke(DeleteProjectCommand $command): void
    {
        if (null === $book = $this->projectRepository->ofId($command->id)) {
            return;
        }

        $this->projectRepository->remove($book);
    }
}
