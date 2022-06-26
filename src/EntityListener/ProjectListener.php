<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Entity\Project;
use App\Message\PublishProjectMessage;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProjectListener
{
    public function __construct(
        private SluggerInterface $slugger,
        private MessageBusInterface $bus
    ) {
    }

    public function prePersist(Project $project, LifecycleEventArgs $event): void
    {
        $project->computeSlug($this->slugger);
    }

    public function postPersist(Project $project, LifecycleEventArgs $event): void
    {
        $this->bus->dispatch(new PublishProjectMessage($project->getId()));
    }

    public function preUpdate(Project $project, LifecycleEventArgs $event): void
    {
        $project->computeSlug($this->slugger);
        $this->bus->dispatch(new PublishProjectMessage($project->getId()));
    }
}
