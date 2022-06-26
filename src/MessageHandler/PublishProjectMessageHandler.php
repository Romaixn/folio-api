<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\Project;
use App\Message\PublishProjectMessage;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Workflow\WorkflowInterface;

final class PublishProjectMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ProjectRepository $projectRepository,
        private readonly MessageBusInterface $bus,
        private readonly WorkflowInterface $workflow,
        private readonly LoggerInterface $logger
    ) {
    }

    public function __invoke(PublishProjectMessage $message): void
    {
        /** @var Project|null $project */
        $project = $this->projectRepository->find($message->getId());
        if (!$project) {
            return;
        }

        if ($this->workflow->can($project, 'publish')) {
            if ($project->isPublished()) {
                $this->workflow->apply($project, 'publish');
                $this->entityManager->flush();

                $this->bus->dispatch($message);
            }
        } elseif ($this->workflow->can($project, 'optimize')) {
            // if ($project->getPhotoFilename()) {
            // $this->imageOptimizer->resize($this->photoDir.'/'.$project->getPhotoFilename());
            // }
            $this->workflow->apply($project, 'optimize');
            $this->entityManager->flush();
        } elseif ($this->workflow->can($project, 'unpublish')) {
            if (!$project->isPublished()) {
                $this->workflow->apply($project, 'unpublish');
                $this->entityManager->flush();
            }
        }

        $this->logger->debug('Workflow Project', ['project' => $project->getId(), 'state' => $project->getState()]);
    }
}
