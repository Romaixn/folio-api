<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Domain\Project\Model\Project;
use App\Infrastructure\Project\ApiPlatform\OpenApi\CategoryFilter;
use App\Infrastructure\Project\ApiPlatform\State\Provider\ProjectCrudProvider;

#[ApiResource(
    shortName: 'Project',
    operations: [
        new GetCollection(filters: [CategoryFilter::class], provider: ProjectCrudProvider::class),
        new Get(provider: ProjectCrudProvider::class),
    ],
)]
final class ProjectResource
{
    public function __construct(
        public ?int $id = null,

        public ?string $title = null,

        public ?string $excerpt = null,

        public ?string $description = null,

        #[ApiProperty(identifier: true, writable: false)]
        public ?string $slug = null,

        public ?\DateTimeImmutable $createdAt = null,

        public ?\DateTimeImmutable $updatedAt = null,

        public ?string $state = null,

        public ?bool $isPublished = false,

        public ?string $url = null,

        public ?string $photoFilename = null,
    ) {
    }

    public static function fromModel(Project $project): static
    {
        return new self($project->id, $project->title, $project->excerpt, $project->description, $project->slug, $project->createdAt, $project->updatedAt, $project->state, $project->isPublished, $project->url, $project->photoFilename);
    }
}
