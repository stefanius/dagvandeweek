<?php

namespace Stef\SpecialDatesBundle\DateParser;

use Stef\SpecialDatesBundle\Dates\ChristmasEvening;
use Stef\SpecialDatesBundle\Dates\DutchPancakeDay;
use Stef\SpecialDatesBundle\Dates\FirstChristmasDay;
use Stef\SpecialDatesBundle\Dates\LastDayOfYear;
use Stef\SpecialDatesBundle\Dates\NewYearsDay;
use Stef\SpecialDatesBundle\Dates\SecondChristmasDay;

class Parser
{
    public function getAllValidDates($year)
    {
        return [
            new ChristmasEvening($year),
            new DutchPancakeDay($year),
            new FirstChristmasDay($year),
            new LastDayOfYear($year),
            new NewYearsDay($year),
            new SecondChristmasDay($year),
        ];
    }
}