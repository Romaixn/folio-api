<?php

declare(strict_types=1);

namespace App\Tests\Project\Functional;

use App\Project\Application\Command\CreateProjectCommand;
use App\Project\Domain\Repository\ProjectRepositoryInterface;
use App\Project\Domain\ValueObject\ProjectExcerpt;
use App\Project\Domain\ValueObject\ProjectTitle;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CreateProjectTest extends KernelTestCase
{
    public function testCreateProject(): void
    {
        /** @var ProjectRepositoryInterface $projectRepository */
        $projectRepository = static::getContainer()->get(ProjectRepositoryInterface::class);

        /** @var CommandBusInterface $commandBus */
        $commandBus = static::getContainer()->get(CommandBusInterface::class);

        static::assertEmpty($projectRepository);

        $commandBus->dispatch(new CreateProjectCommand(
            new ProjectTitle('title'),
            new ProjectExcerpt('excerpt'),
        ));

        static::assertCount(1, $projectRepository);

        $project = array_values(iterator_to_array($projectRepository))[0];

        static::assertEquals(new ProjectTitle('title'), $project->title);
        static::assertEquals(new ProjectExcerpt('excerpt'), $project->excerpt);
    }
}
