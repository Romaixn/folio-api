<?php

declare(strict_types=1);

namespace App\Application\Project\Command;

use App\Application\Shared\Command\CommandInterface;
use Webmozart\Assert\Assert;

final class CreateProjectCommand implements CommandInterface
{
    public function __construct(
        public readonly string $title,
        public readonly string $excerpt,
        public readonly string $description,
        public readonly string $slug,
        public readonly \DateTimeImmutable $createdAt,
        public readonly \DateTimeImmutable $updatedAt,
        public readonly string $state,
        public readonly bool $isPublished,
        public readonly ?string $url,
        public readonly ?string $photoFilename
    ) {
        Assert::lengthBetween($title, 1, 255);
        Assert::lengthBetween($excerpt, 1, 255);
        Assert::minLength($description, 100);
        Assert::nullOrStartsWith($url, 'https://');
        Assert::inArray($state, ['draft', 'published']);
    }
}
