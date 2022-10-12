<?php

declare(strict_types=1);

namespace App\Contact\Service;

use App\Contact\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class SendMail
{
    public function __construct(private readonly MailerInterface $mailer, private readonly string $adminEmail)
    {
    }

    public function send(Contact $contact): void
    {
        $this->mailer->send((new TemplatedEmail())
            ->subject('Nouveau message via le formulaire de contact')
            ->htmlTemplate('emails/contact.html.twig')
            ->from(new Address($this->adminEmail, 'Romain Herault'))
            ->to(new Address($this->adminEmail))
            ->addReplyTo($contact->email ?? '')
            ->context([
                'contact' => $contact,
            ])
        );
    }
}
