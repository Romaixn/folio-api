<?php

declare(strict_types=1);

namespace App\Tests\Contact\Acceptance;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Contact\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Test\MailerAssertionsTrait;

final class ContactPostTest extends ApiTestCase
{
    use MailerAssertionsTrait;

    public function testCreateContact(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/contact', [
            'json' => [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => 'john@doe.fr',
                'subject' => 'Subject',
                'message' => 'Message',
            ],
        ]);

        static::assertResponseIsSuccessful();
        static::assertMatchesResourceItemJsonSchema(Contact::class);

        static::assertJsonContains([
            'email' => 'john@doe.fr',
        ]);

        static::assertEmailCount(1);

        $email = static::getMailerMessage();

        static::assertEmailHtmlBodyContains($email, 'Message de contact');
        static::assertEmailHtmlBodyContains($email, 'Prénom : John');
        static::assertEmailHtmlBodyContains($email, 'Nom : Doe');
        static::assertEmailHtmlBodyContains($email, 'E-mail : john@doe.fr');
        static::assertEmailHtmlBodyContains($email, 'Sujet : Subject');
        static::assertEmailHtmlBodyContains($email, 'Message');
    }

    public function testCreateContactWithPhone(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/contact', [
            'json' => [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => 'john@doe.fr',
                'subject' => 'Subject',
                'message' => 'Message',
                'phone' => '0606060606',
            ],
        ]);

        static::assertResponseIsSuccessful();
        static::assertMatchesResourceItemJsonSchema(Contact::class);

        static::assertJsonContains([
            'email' => 'john@doe.fr',
        ]);

        static::assertEmailCount(1);

        $email = static::getMailerMessage();

        static::assertEmailHtmlBodyContains($email, 'Message de contact');
        static::assertEmailHtmlBodyContains($email, 'Prénom : John');
        static::assertEmailHtmlBodyContains($email, 'Nom : Doe');
        static::assertEmailHtmlBodyContains($email, 'E-mail : john@doe.fr');
        static::assertEmailHtmlBodyContains($email, 'Téléphone : 0606060606');
        static::assertEmailHtmlBodyContains($email, 'Sujet : Subject');
        static::assertEmailHtmlBodyContains($email, 'Message');
    }

    public function testCreateInvalidContact(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/contact', [
            'json' => [
                'firstName' => 'John',
                'lastName' => 'Doe',
                'email' => 'john.doe',
                'subject' => 'Subject',
                'message' => 'Message',
            ],
        ]);

        static::assertResponseIsUnprocessable();

        static::assertJsonContains([
            'violations' => [
                ['propertyPath' => 'email', 'message' => 'This value is not a valid email address.'],
            ],
        ]);

        $client->request('POST', '/api/contact', [
            'json' => [
                'firstName' => '',
                'lastName' => '',
                'email' => '',
                'subject' => '',
                'message' => '',
            ],
        ]);

        static::assertResponseIsUnprocessable();

        static::assertJsonContains([
            'violations' => [
                ['propertyPath' => 'firstName', 'message' => 'This value should not be blank.'],
                ['propertyPath' => 'lastName', 'message' => 'This value should not be blank.'],
                ['propertyPath' => 'email', 'message' => 'This value should not be blank.'],
                ['propertyPath' => 'subject', 'message' => 'This value should not be blank.'],
                ['propertyPath' => 'message', 'message' => 'This value should not be blank.'],
            ],
        ]);
    }
}
