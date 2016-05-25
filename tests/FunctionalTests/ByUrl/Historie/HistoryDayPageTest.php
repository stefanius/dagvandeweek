<?php

namespace Tests\FunctionalTests\ByUrl\Kalender;

use Tests\FunctionalTests\AbstractFunctionalTestCase;

class HistoryYearDayTest extends AbstractFunctionalTestCase
{
    protected $route = '/historie';

    /**
     * @dataProvider predefinedYearProvider
     *
     * @param $year
     * @param $monthNumber
     * @param $monthName
     * @param $quarterTitle
     * @param $day
     */
    public function testPredefinedDayHistoryPages($year, $monthNumber, $day, $monthName)
    {
        $crawler = $this->browse(sprintf("%s/%s/%s/%s", $this->route, $year, $monthNumber));

        $this->assertEquals(sprintf('Geschiedenis van %s %s', $monthName, $year), $crawler->filter('h1')->eq(0)->text());
        $this->assertEquals(sprintf('%s in getallen', ucfirst($monthName)), $crawler->filter('h2')->eq(0)->text());

        $this->assertEquals(sprintf("%s/%s/%02d/%02d", $this->route, $year, $monthNumber, $day), $this->client->getRequest()->getRequestUri());
    }

    /**
     * @return array
     */
    public function predefinedYearProvider()
    {
        return [
            [1960, '01', '10', 'januari'],
            [1965, '04', '01', 'april'],
            [1970, '08', '09', 'augustus'],
            [1975, '11', '30', 'november'],
            //Below redirects months below '10' to a two digit page (i.e. '1960/1' -> '1960/01')
            [1960, 1, 1, 'januari'],
            [1960, 2, 2, 'februari'],
            [1960, 3, 3, 'maart'],
            [1960, 4, 4, 'april'],
            [1960, 5, 5, 'mei'],
            [1960, 6, 6, 'juni'],
            [1960, 7, 7, 'juli'],
            [1960, 8, 8, 'augustus'],
            [1960, 9, 9, 'september'],
            [1960, 10, 1, 'oktober'],
            [1960, 11, 2, 'november'],
            [1960, 12, 12, 'december'],
        ];
    }
}