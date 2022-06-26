<?php

declare(strict_types=1);

namespace App\Message;

final class PublishProjectMessage
{
    public function __construct(private ?int $id = null)
    {
    }

    public function getId(): int|null
    {
        return $this->id;
    }
}
