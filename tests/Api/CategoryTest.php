<?php

declare(strict_types=1);

namespace App\Tests\Api;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;

class CategoryTest extends ApiTestCase
{
    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/api/categories');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/api/categories']);
    }
}
