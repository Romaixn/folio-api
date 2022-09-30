<?php

declare(strict_types=1);

namespace App\Project\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

#[ORM\Embeddable]
final class ProjectContent
{
    #[ORM\Column(name: 'content', length: 65535)]
    public readonly string $value;

    public function __construct(string $value)
    {
        Assert::lengthBetween($value, 1, 65535);

        $this->value = $value;
    }
}