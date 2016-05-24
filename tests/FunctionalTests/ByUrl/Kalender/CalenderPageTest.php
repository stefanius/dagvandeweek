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
        $this->checkMonthNames($crawler, $year);
    }

    /**
     * @dataProvider leapYearProvider
     *
     * @param $year
     */
    public function testLeapYearCalenderPages($year)
    {
        $crawler = $this->browse(sprintf("%s/%s", $this->route, $year));

        $this->assertEquals('Kalender ' . $year, $crawler->filter('h1')->eq(0)->text());
        $this->assertEquals('Maandoverzicht', $crawler->filter('h2:contains(Maandoverzicht)')->eq(0)->text());
        $this->assertEquals('Schrikkeljaar', $crawler->filter('h2:contains(Schrikkeljaar)')->eq(0)->text());
        $this->checkMonthNames($crawler, $year);
    }

    /**
     * @dataProvider nonLeapYearProvider
     *
     * @param $year
     */
    public function testNonLeapYearCalenderPages($year)
    {
        $crawler = $this->browse(sprintf("%s/%s", $this->route, $year));

        $this->assertEquals('Kalender ' . $year, $crawler->filter('h1')->eq(0)->text());
        $this->assertEquals('Maandoverzicht', $crawler->filter('h2:contains(Maandoverzicht)')->eq(0)->text());
        $this->assertEquals('Geen Schrikkeljaar', $crawler->filter('h2:contains(Geen Schrikkeljaar)')->eq(0)->text());
        $this->checkMonthNames($crawler, $year);
    }

    protected function checkMonthNames($crawler, $year)
    {
        $months = [
            'Januari',
            'Februari',
            'Maart',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Augustus',
            'September',
            'Oktober',
            'November',
            'December',
        ];

        foreach ($months as $month) {
            $this->assertEquals($month . ' ' . $year, $crawler->filter('h3:contains(' . $month . ')')->eq(0)->text());
        }
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
    public function leapYearProvider()
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
        ];
    }

    /**
     * @return array
     */
    public function nonLeapYearProvider()
    {
        return [
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