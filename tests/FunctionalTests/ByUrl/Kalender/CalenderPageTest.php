<?php

namespace Tests\FunctionalTests\ByUrl\Kalender;

use Tests\FunctionalTests\AbstractFunctionalTestCase;

class CalenderPageTest extends AbstractFunctionalTestCase
{
    protected $route = '/kalender';

    /**
     * @dataProvider randomYearProvider
     *
     * @param $year
     */
    public function testRandomlyCalenderPages($year)
    {
        $crawler = $this->browse(sprintf("%s/%s", $this->route, $year));

        $this->assertEquals('Kalender ' . $year, $crawler->filter('h1')->eq(0)->text());
        $this->assertEquals('Maandoverzicht', $crawler->filter('h2:contains(Maandoverzicht)')->eq(0)->text());
    }

    /**
     * @return array
     */
    public function randomYearProvider()
    {
        $array = [];

        for($i = 1; $i < 50; $i++) {
            $year = rand(1800 , 2100);

            $array[$i] = [$year];
        }

        return $array;
    }
}