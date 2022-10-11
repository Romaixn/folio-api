<?php

declare(strict_types=1);

namespace App\Contact\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Contact\Entity\Contact;
use App\Contact\Service\SendMail;
use Webmozart\Assert\Assert;

class ContactPostProcessor implements ProcessorInterface
{
    public function __construct(private readonly SendMail $sendMail)
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): Contact
    {
        Assert::isInstanceOf($data, Contact::class);

        $this->sendMail->send($data);

        return $data;
    }
}
