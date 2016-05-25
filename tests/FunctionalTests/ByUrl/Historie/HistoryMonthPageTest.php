<?php

namespace Tests\FunctionalTests\ByUrl\Kalender;

use Tests\FunctionalTests\AbstractFunctionalTestCase;

class HistoryYearMonthTest extends AbstractFunctionalTestCase
{
    protected $route = '/historie';

    /**
     * @dataProvider predefinedYearProvider
     *
     * @param $year
     */
    public function testPredefinedMonthHistoryPages($year, $monthNumber, $monthName, $quarterTitle)
    {
        $crawler = $this->browse(sprintf("%s/%s/%s", $this->route, $year, $monthNumber));

        $this->assertEquals(sprintf('Geschiedenis van %s %s', $monthName, $year), $crawler->filter('h1')->eq(0)->text());
        $this->assertEquals(sprintf('%s in getallen', ucfirst($monthName)), $crawler->filter('h2')->eq(0)->text());
        $this->assertEquals($quarterTitle, $crawler->filter('h2')->eq(1)->text());

        $this->assertEquals(sprintf("%s/%s/%02d", $this->route, $year, $monthNumber), $this->client->getRequest()->getRequestUri());
    }

    /**
     * @return array
     */
    public function predefinedYearProvider()
    {
        return [
            [1960, '01', 'januari', 'Eerste kwartaal'],
            [1965, '04', 'april', 'Tweede kwartaal'],
            [1970, '08', 'augustus', 'Derde kwartaal'],
            [1975, '11', 'november', 'Vierde kwartaal'],
            //Below redirects months below '10' to a two digit page (i.e. '1960/1' -> '1960/01')
            [1960, 1, 'januari', 'Eerste kwartaal'],
            [1960, 2, 'februari', 'Eerste kwartaal'],
            [1960, 3, 'maart', 'Eerste kwartaal'],
            [1960, 4, 'april', 'Tweede kwartaal'],
            [1960, 5, 'mei', 'Tweede kwartaal'],
            [1960, 6, 'juni', 'Tweede kwartaal'],
            [1960, 7, 'juli', 'Derde kwartaal'],
            [1960, 8, 'augustus', 'Derde kwartaal'],
            [1960, 9, 'september', 'Derde kwartaal'],
            [1960, 10, 'oktober', 'Vierde kwartaal'],
            [1960, 11, 'november', 'Vierde kwartaal'],
            [1960, 12, 'december', 'Vierde kwartaal'],
        ];
    }
}