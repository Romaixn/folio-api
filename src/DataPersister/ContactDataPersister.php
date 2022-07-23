<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Contact;
use App\Service\SendMail;

class ContactDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(private SendMail $sendMail)
    {
    }

    /** @phpstan-ignore-next-line */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Contact;
    }

    /**
     * @param Contact      $data
     * @param array<mixed> $context
     */
    public function persist($data, array $context = []): void
    {
        $this->sendMail->send($data);
    }

    /** @phpstan-ignore-next-line */
    public function remove($data, array $context = []): void
    {
        // remove $data
    }
}
