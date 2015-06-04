<?php

namespace Stef\SpecialDatesBundle\Dates;

class SecondChristmasDay extends AbstractSpecialDate
{
    protected function generate()
    {
        $this->description = 'Tweede Kerstdag';

        $this->startDate   = \DateTime::createFromFormat('Y-m-d', $this->year . '-12-26');
        $this->endDate     = \DateTime::createFromFormat('Y-m-d', $this->year . '-12-26');
        $this->totalLength = 1;
    }
}
