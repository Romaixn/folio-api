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

    #[ORM\Column]
    public \DateTimeImmutable $createdAt;

    #[ORM\Column(nullable: true)]
    public ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    public string $state = 'draft';

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
        public bool $isPublished = false,

        #[ORM\Column(nullable: true)]
        public ?string $url = null,

        #[ORM\Column(nullable: true)]
        public ?string $photoFilename = null,
    ) {
        $this->id = Uuid::v4();
        $this->createdAt = new \DateTimeImmutable();

        Assert::lengthBetween($title, 1, 255);
        Assert::lengthBetween($excerpt, 1, 255);
        Assert::minLength($description, 100);
        Assert::nullOrStartsWith($url, 'http');
    }
}
