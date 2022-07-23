<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\InMemory;

use App\Domain\Project\Model\Project;
use App\Domain\Project\Repository\ProjectRepositoryInterface;
use App\Infrastructure\Shared\InMemory\InMemoryRepository;

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

    public function ofSlug(string $slug): ?Project
    {
        return $this->entities[(string) $slug] ?? null;
    }

    public function withCategory(string $category): static
    {
        return $this->filter(fn (Project $project) => $project->category === $category);
    }
}
