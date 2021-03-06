<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Contact;
use App\Entity\Subscriber;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class SendMail
{
    public function __construct(private MailerInterface $mailer, private string $adminEmail)
    {
    }

    public function confirmation(Subscriber $subscriber): void
    {
        $this->mailer->send((new TemplatedEmail())
            ->from(new Address($this->adminEmail, 'Romain Herault'))
            ->to(new Address((string) $subscriber->getEmail()))
            ->subject('Confirmation de votre inscription - Romain Herault Newsletter')
            ->htmlTemplate('emails/confirmation.html.twig')
            ->context([
                'subscriber' => $subscriber,
            ])
        );
    }

    public function send(Contact $contact): void
    {
        $this->mailer->send((new NotificationEmail())
            ->subject('Nouveau message via le formulaire de contact')
            ->htmlTemplate('emails/contact.html.twig')
            ->from($this->adminEmail)
            ->to($this->adminEmail)
            ->addReplyTo($contact->getEmail())
            ->context([
                'contact' => $contact,
            ])
        );
    }
}
