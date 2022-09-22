<?php

declare(strict_types=1);

namespace App\Tests\Project\Functional;

use App\Project\Application\Command\UpdateProjectCommand;
use App\Project\Domain\Repository\ProjectRepositoryInterface;
use App\Project\Domain\ValueObject\ProjectContent;
use App\Project\Domain\ValueObject\ProjectExcerpt;
use App\Project\Domain\ValueObject\ProjectTitle;
use App\Shared\Application\Command\CommandBusInterface;
use App\Tests\Project\DummyFactory\DummyProjectFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class UpdateProjectTest extends KernelTestCase
{
    public function testUpdateProject(): void
    {
        /** @var ProjectRepositoryInterface $projectRepository */
        $projectRepository = static::getContainer()->get(ProjectRepositoryInterface::class);

        /** @var CommandBusInterface $commandBus */
        $commandBus = static::getContainer()->get(CommandBusInterface::class);

        $initialProject = DummyProjectFactory::createProject(
            title: 'title',
            excerpt: 'excerpt',
            content: 'content'
        );

        $projectRepository->save($initialProject);

        $commandBus->dispatch(new UpdateProjectCommand(
            $initialProject->id,
            title: new ProjectTitle('newTitle'),
            content: new ProjectContent('newContent')
        ));

        $project = $projectRepository->ofId($initialProject->id);

        static::assertEquals(new ProjectTitle('newTitle'), $project->title);
        static::assertEquals(new ProjectExcerpt('excerpt'), $project->excerpt);
        static::assertEquals(new ProjectContent('newContent'), $project->content);
    }
}
