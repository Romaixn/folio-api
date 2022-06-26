<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\Project;
use Psr\Log\LoggerInterface;
use App\Repository\ProjectRepository;
use App\Message\PublishProjectMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\WorkflowInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class PublishProjectMessageHandler implements MessageHandlerInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ProjectRepository $projectRepository,
        private MessageBusInterface $bus,
        private WorkflowInterface $projectStateMachine,
        private LoggerInterface $logger
    ) {}

    public function __invoke(PublishProjectMessage $message)
    {
        /** @var Project $project */
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
        } elseif ($this->logger) {
            $this->logger->debug('Dropping project', ['project' => $project->getId(), 'state' => $project->getState()]);
        }
    }
}
