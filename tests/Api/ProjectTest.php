<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class ProjectTest extends ApiTestCase
{
    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/api/projects');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/api/projects']);
    }
}
