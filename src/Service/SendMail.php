<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendMail
{
    public function __construct(private MailerInterface $mailer, private string $adminEmail)
    {
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
