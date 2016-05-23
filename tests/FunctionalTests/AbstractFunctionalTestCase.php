<?php

namespace Tests\FunctionalTests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AbstractFunctionalTestCase extends WebTestCase
{
    protected $client;

    protected function setUp()
    {
        parent::setUp();

        $this->client = $client = static::createClient();
    }

    protected function browse($uri, $method = 'GET')
    {
        return $this->client->request($method, $uri);
    }
}