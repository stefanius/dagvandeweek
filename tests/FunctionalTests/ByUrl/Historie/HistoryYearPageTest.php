<?php

namespace Tests\FunctionalTests\ByUrl\Kalender;

use Tests\FunctionalTests\AbstractFunctionalTestCase;

class HistoryYearPageTest extends AbstractFunctionalTestCase
{
    protected $route = '/historie';

    /**
     * @dataProvider randomYearProvider
     *
     * @param $year
     */
    public function testRandomlyHistoryYearPages($year)
    {
        $crawler = $this->browse(sprintf("%s/%s", $this->route, $year));

        $this->assertEquals('Historie ' . $year, $crawler->filter('h1')->eq(0)->text());
        $this->assertEquals('Gebeurtenissen ' . $year, $crawler->filter('h2')->eq(0)->text());
        $this->assertEquals('Jaaroverzicht', $crawler->filter('h3')->eq(0)->text());
    }

    /**
     * @dataProvider predefinedYearProvider
     *
     * @param $year
     */
    public function testPredefinedYearHistoryPages($year)
    {
        $crawler = $this->browse(sprintf("%s/%s", $this->route, $year));

        $this->assertEquals('Historie ' . $year, $crawler->filter('h1')->eq(0)->text());
        $this->assertEquals('Gebeurtenissen ' . $year, $crawler->filter('h2')->eq(0)->text());
        $this->assertEquals('Jaaroverzicht', $crawler->filter('h3')->eq(0)->text());
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

    /**
     * @return array
     */
    public function predefinedYearProvider()
    {
        return [
            [1960],
            [1980],
            [1996],
            [2012],
            [1940],
            [1964],
            [1972],
            [1976],
            [2000],
            [1961],
            [1981],
            [1997],
            [2013],
            [1941],
            [1942],
            [1965],
            [1700],
            [1800],
            [1900],
            [2100],
            [2200],
        ];
    }
}