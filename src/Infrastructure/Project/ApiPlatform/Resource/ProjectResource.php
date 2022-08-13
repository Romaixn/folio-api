<?php

declare(strict_types=1);

namespace App\Infrastructure\Project\ApiPlatform\Resource;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use Symfony\Component\Uid\Uuid;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use App\Domain\Project\Model\Project;
use ApiPlatform\Metadata\GetCollection;
use App\Infrastructure\Project\ApiPlatform\OpenApi\CategoryFilter;
use App\Infrastructure\Project\ApiPlatform\State\Provider\ProjectCrudProvider;
use App\Infrastructure\Project\ApiPlatform\State\Processor\ProjectCrudProcessor;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Project',
    operations: [
        new GetCollection(filters: [CategoryFilter::class], provider: ProjectCrudProvider::class),
        new Get(provider: ProjectCrudProvider::class),
        new Post(validationContext: ['groups' => ['create']], processor: ProjectCrudProcessor::class),
        new Patch(processor: ProjectCrudProcessor::class),
        new Delete(processor: ProjectCrudProcessor::class),
    ],
)]
final class ProjectResource
{
    public function __construct(
        public ?Uuid $id = null,

        #[Assert\NotNull(groups: ['create'])]
        public ?string $title = null,

        #[Assert\NotNull(groups: ['create'])]
        public ?string $excerpt = null,

        #[Assert\NotNull(groups: ['create'])]
        public ?string $description = null,

        #[ApiProperty(identifier: true, writable: false)]
        public ?string $slug = null,

        public ?\DateTimeImmutable $createdAt = null,

        public ?\DateTimeImmutable $updatedAt = null,

        public ?string $state = null,

        #[Assert\NotNull(groups: ['create'])]
        public ?bool $isPublished = false,

        public ?string $url = null,

        public ?string $photoFilename = null,
    ) {
        $this->id = $id ?? Uuid::v4();
    }

    public static function fromModel(Project $project): static
    {
        return new self($project->id, $project->title, $project->excerpt, $project->description, $project->slug, $project->createdAt, $project->updatedAt, $project->state, $project->isPublished, $project->url, $project->photoFilename);
    }
}
