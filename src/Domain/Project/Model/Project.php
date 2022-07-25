<?php

declare(strict_types=1);

namespace App\Domain\Project\Model;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

#[ORM\Entity]
class Project
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid')]
    public readonly Uuid $id;

    public function __construct(
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
        $this->id = Uuid::v4();

        Assert::lengthBetween($title, 1, 255);
        Assert::lengthBetween($excerpt, 1, 255);
        Assert::minLength($description, 100);
        Assert::nullOrStartsWith($url, 'https://');
        Assert::inArray($state, ['draft', 'published']);
    }
}
