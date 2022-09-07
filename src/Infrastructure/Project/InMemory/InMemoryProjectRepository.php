<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\InMemory;

use App\Domain\Project\Model\Project;
use App\Domain\Project\Repository\ProjectRepositoryInterface;
use App\Infrastructure\Shared\InMemory\InMemoryRepository;
use Symfony\Component\Uid\Uuid;

final class InMemoryProjectRepository extends InMemoryRepository implements ProjectRepositoryInterface
{
    public function add(Project $project): void
    {
        $this->entities[(string) $project->id] = $project;
    }

    public function remove(Project $project): void
    {
        unset($this->entities[(string) $project->id]);
    }

    public function ofId(Uuid $id): ?Project
    {
        return $this->entities[(string) $id] ?? null;
    }

    public function ofSlug(string $slug): ?Project
    {
        return $this->entities[(string) $slug] ?? null;
    }
}
