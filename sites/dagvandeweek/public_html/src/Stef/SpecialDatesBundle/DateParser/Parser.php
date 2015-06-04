<?php

namespace Stef\SpecialDatesBundle\DateParser;

use Stef\SpecialDatesBundle\Dates\ChristmasEvening;
use Stef\SpecialDatesBundle\Dates\DutchPancakeDay;
use Stef\SpecialDatesBundle\Dates\FirstChristmasDay;
use Stef\SpecialDatesBundle\Dates\LastDayOfYear;
use Stef\SpecialDatesBundle\Dates\NewYearsDay;
use Stef\SpecialDatesBundle\Dates\SecondChristmasDay;
use Stef\SpecialDatesBundle\Dates\WorldPiDay;

class Parser
{
    public function getAllDates($year)
    {
        return [
            new NewYearsDay($year),
            new DutchPancakeDay($year),
            new WorldPiDay($year),
            new ChristmasEvening($year),
            new FirstChristmasDay($year),
            new SecondChristmasDay($year),
            new LastDayOfYear($year),
        ];
    }

    public function getAllValidDates($year)
    {
        $items = $this->getAllDates($year);

        foreach ($items as $key => $value) {
            if ($value->isValid() === false) {
                unset($items[$key]);
            }
        }

        return $items;
    }
}
