<?php

namespace Stef\SpecialDatesBundle\Tests\Dates;

use Stef\SpecialDatesBundle\Dates\DutchPancakeDay;

class SecondChristmasDayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider provider
     */
    public function testSlugManipulator($year, $dateformat, $expected)
    {
        $specialDate = new DutchPancakeDay($year);

        var_dump($specialDate->getStartDate());

        //$this->assertEquals($expected, $result);
    }

    public function provider()
    {
        return [
            [2000, '', ''],
            [2005, '', ''],
            [2006, '', ''],
            [2007, '', ''],
            [2009, '', ''],
            [2015, '', ''],
        ];
    }
}
