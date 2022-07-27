<?php

declare(strict_types=1);

namespace App\Application\Project\Command;

use App\Application\Shared\Command\CommandInterface;
use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

final class UpdateProjectCommand implements CommandInterface
{
    public \DateTimeImmutable $updatedAt;

    public function __construct(
        public readonly Uuid $id,
        public readonly ?string $title = null,
        public readonly ?string $excerpt = null,
        public readonly ?string $description = null,
        public readonly bool $isPublished = false,
        public readonly ?string $url = null,
        public readonly ?string $photoFilename = null
    ) {
        $this->updatedAt = new \DateTimeImmutable();

        Assert::nullOrLengthBetween($title, 1, 255);
        Assert::nullOrLengthBetween($excerpt, 1, 255);
        Assert::nullOrMinLength($description, 100);
        Assert::nullOrStartsWith($url, 'https://');
    }
}
