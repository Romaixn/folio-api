<?php

declare(strict_types=1);

namespace App\Application\Project\Command;

use App\Application\Shared\Command\CommandInterface;
use Symfony\Component\Uid\Uuid;

final class DeleteProjectCommand implements CommandInterface
{
    public function __construct(
        public readonly Uuid $id,
    ) {
    }
}
