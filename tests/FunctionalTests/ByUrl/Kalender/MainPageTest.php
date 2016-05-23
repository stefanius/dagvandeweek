<?php

namespace Tests\FunctionalTests\ByUrl\Kalender;

use Tests\FunctionalTests\AbstractFunctionalTestCase;

class MainPageTest extends AbstractFunctionalTestCase
{
    protected $route = '/kalender';

    public function testTitle()
    {
        $crawler = $this->browse($this->route);

        $this->assertEquals('Jaarkalenders', $crawler->filter('h1')->eq(0)->text());
    }

    public function testSubTitles()
    {
        $crawler = $this->browse($this->route);

        $this->assertEquals('Beschikbare jaren', $crawler->filter('h4')->eq(0)->text());
        $this->assertEquals('Nog meer kalenders', $crawler->filter('h4')->eq(1)->text());
    }
}