<?php

declare(strict_types=1);

namespace App\Domain\Project\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Entity]
class Project
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column()]
        public readonly int $id,

        #[ORM\Column]
        public string $title,

        #[ORM\Column]
        public string $excerpt,

        #[ORM\Column(type: Types::TEXT)]
        public string $description,

        #[ORM\Column]
        public string $slug,

        #[ORM\Column]
        public \DateTimeImmutable $createdAt,

        #[ORM\Column]
        public \DateTimeImmutable $updatedAt,

        #[ORM\Column]
        public string $state = 'draft',

        #[ORM\Column]
        public bool $isPublished = false,

        #[ORM\Column]
        public ?string $url = null,

        #[ORM\Column]
        public ?string $photoFilename = null,
    ) {
        Assert::lengthBetween($title, 1, 255);
        Assert::lengthBetween($excerpt, 1, 255);
        Assert::minLength($description, 100);
        Assert::nullOrStartsWith($url, 'https://');
        Assert::inArray($state, ['draft', 'published']);
    }
}
