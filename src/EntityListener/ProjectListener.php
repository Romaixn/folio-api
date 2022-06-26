<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Entity\Project;
use App\Message\ProjectMessage;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProjectListener
{
    private $slugger;
    private $bus;

    public function __construct(SluggerInterface $slugger, MessageBusInterface $bus)
    {
        $this->slugger = $slugger;
        $this->bus = $bus;
    }

    public function prePersist(Project $project, LifecycleEventArgs $event)
    {
        $project->computeSlug($this->slugger);
    }

    public function postPersist(Project $project, LifecycleEventArgs $event)
    {
        $this->bus->dispatch(new ProjectMessage($project->getId()));
    }

    public function preUpdate(Project $project, LifecycleEventArgs $event)
    {
        $project->computeSlug($this->slugger);
        $this->bus->dispatch(new ProjectMessage($project->getId()));
    }
}
