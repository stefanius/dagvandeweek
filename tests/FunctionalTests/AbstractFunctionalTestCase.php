<?php

namespace Tests\FunctionalTests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;

abstract class AbstractFunctionalTestCase extends WebTestCase
{
    /**
     * @var Client
     */
    protected $client;

    protected static $application;

    protected static function runCommand($command)
    {
        $command = sprintf('%s --quiet', $command);

        return self::getApplication()->run(new StringInput($command));
    }

    protected static function getApplication()
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
        }

        return self::$application;
    }

    protected function setUp()
    {
        parent::setUp();

        $this->client = $client = static::createClient();

        self::runCommand('doctrine:database:create');
        self::runCommand('doctrine:schema:update --force');
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