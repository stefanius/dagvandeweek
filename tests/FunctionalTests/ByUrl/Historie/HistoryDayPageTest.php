<?php

namespace Tests\FunctionalTests\ByUrl\Historie;

use Tests\FunctionalTests\AbstractFunctionalTestCase;

class HistoryDayPageTest extends AbstractFunctionalTestCase
{
    protected $route = '/historie';

    /**
     * @dataProvider predefinedYearProvider
     *
     * @param $year
     * @param $monthNumber
     * @param $monthName
     * @param $day
     */
    public function testPredefinedDayHistoryPages($year, $monthNumber, $day, $monthName, $expectedWeekDay)
    {
        $crawler = $this->browse(sprintf("%s/%s/%s/%s", $this->route, $year, $monthNumber, $day));

        $this->assertEquals(sprintf('%s %02d %s %s', $expectedWeekDay, $day, $monthName, $year), $crawler->filter('h1')->eq(0)->text());
        $this->assertEquals(sprintf('Gebeurtenissen %02d %s %s', $day, $monthName, $year), $crawler->filter('h2')->eq(0)->text());

        $this->assertEquals(sprintf("%s/%s/%02d/%02d", $this->route, $year, $monthNumber, $day), $this->client->getRequest()->getRequestUri());
    }

    /**
     * @return array
     */
    public function predefinedYearProvider()
    {
        return [
            [1960, '01', '10', 'januari', 'zondag'],
            [1965, '04', '01', 'april', 'donderdag'],
            [1970, '08', '09', 'augustus', 'zondag'],
            [1975, '11', '30', 'november', 'zondag'],
            //Below redirects months below '10' to a two digit page (i.e. '1960/1' -> '1960/01')
            [1960, 1, 1, 'januari', 'vrijdag'],
            [1960, 2, 2, 'februari', 'dinsdag'],
            [1960, 3, 3, 'maart', 'donderdag'],
            [1960, 4, 4, 'april', 'maandag'],
            [1960, 5, 5, 'mei', 'donderdag'],
            [1960, 6, 6, 'juni', 'maandag'],
            [1960, 7, 7, 'juli', 'donderdag'],
            [1960, 8, 8, 'augustus', 'maandag'],
            [1960, 9, 9, 'september', 'vrijdag'],
            [1960, 10, 1, 'oktober', 'zaterdag'],
            [1960, 11, 2, 'november', 'woensdag'],
            [1960, 12, 12, 'december', 'maandag'],
        ];
    }
}