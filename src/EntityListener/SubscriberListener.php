<?php

declare(strict_types=1);

namespace App\EntityListener;

use App\Entity\Subscriber;
use App\Service\SendMail;
use Doctrine\ORM\Event\LifecycleEventArgs;

class SubscriberListener
{
    public function __construct(
        private SendMail $sendMail
    ) {
    }

    public function postPersist(Subscriber $subscriber, LifecycleEventArgs $event): void
    {
        $this->sendMail->confirmation($subscriber);
    }
}
