<?php

namespace Tests\FunctionalTests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractFunctionalTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    protected function setUp()
    {
        parent::setUp();

        $this->client = $client = static::createClient();
    }

    /**
     * @param $uri
     * @param string $method
     *
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function browse($uri, $method = 'GET')
    {
        $this->client->followRedirects(true);

        return $this->client->request($method, $uri);
    }
}