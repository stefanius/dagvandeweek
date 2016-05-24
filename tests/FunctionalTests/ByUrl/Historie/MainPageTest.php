<?php

namespace Tests\FunctionalTests\ByUrl\Historie;

use Tests\FunctionalTests\AbstractFunctionalTestCase;

class MainPageTest extends AbstractFunctionalTestCase
{
    protected $route = '/historie';

    public function testTitle()
    {
        $crawler = $this->browse($this->route);

        $this->assertEquals('Historisch Jaaroverzicht', $crawler->filter('h1')->eq(0)->text());
    }

    public function testSubTitles()
    {
        $crawler = $this->browse($this->route);

        $this->assertEquals('Nieuw binnen', $crawler->filter('h2')->eq(0)->text());
        $this->assertEquals('Beschikbare jaren', $crawler->filter('h4:contains(jaren)')->eq(0)->text());
    }
}