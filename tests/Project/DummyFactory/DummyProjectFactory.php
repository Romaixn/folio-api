<?php

declare(strict_types=1);

namespace App\Tests\Project\DummyFactory;

use App\Project\Domain\Model\Project;
use App\Project\Domain\ValueObject\ProjectContent;
use App\Project\Domain\ValueObject\ProjectExcerpt;
use App\Project\Domain\ValueObject\ProjectTitle;

final class DummyProjectFactory
{
    private function __construct()
    {
    }

    public static function createProject(
        string $title = 'title',
        string $excerpt = 'excerpt',
        string $content = 'content',
    ): Project {
        return new Project(
            new ProjectTitle($title),
            new ProjectExcerpt($excerpt),
            new ProjectContent($content),
        );
    }
}
