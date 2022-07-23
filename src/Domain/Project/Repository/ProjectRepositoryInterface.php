<?php

declare(strict_types=1);

namespace App\Domain\Project\Repository;

use App\Domain\Project\Model\Project;
use App\Domain\Shared\Repository\RepositoryInterface;

/**
 * @extends RepositoryInterface<Project>
 */
interface ProjectRepositoryInterface extends RepositoryInterface
{
    public function add(Project $project): void;

    public function remove(Project $project): void;

    public function ofSlug(string $slug): ?Project;

    public function withCategory(string $category): static;
}
