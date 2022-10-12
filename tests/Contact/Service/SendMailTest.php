<?php

declare(strict_types=1);

namespace App\Tests\Contact\Service;

use App\Contact\Entity\Contact;
use App\Contact\Service\SendMail;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\MailerAssertionsTrait;

final class SendMailTest extends KernelTestCase
{
    use MailerAssertionsTrait;

    public function testMailIsSentAndContentIsOk(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        /* @var SendMail $sendMail */
        $sendMail = $container->get(SendMail::class);
        $contact = new Contact(
            null,
            'John',
            'Doe',
            'john@doe.fr',
            'Subject',
            'Message'
        );
        $sendMail->send($contact);

        static::assertEmailCount(1);

        $email = static::getMailerMessage();

        static::assertEmailHtmlBodyContains($email, 'Message de contact');
        static::assertEmailHtmlBodyContains($email, 'Prénom : John');
        static::assertEmailHtmlBodyContains($email, 'Nom : Doe');
        static::assertEmailHtmlBodyContains($email, 'E-mail : john@doe.fr');
        static::assertEmailHtmlBodyContains($email, 'Sujet : Subject');
        static::assertEmailHtmlBodyContains($email, 'Message');
    }
}
