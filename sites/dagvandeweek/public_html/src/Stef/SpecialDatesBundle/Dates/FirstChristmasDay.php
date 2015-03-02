<?php

namespace Stef\SpecialDatesBundle\Dates;

class FirstChristmasDay extends AbstractSpecialDate
{
    protected function generate()
    {
        $this->startDate = \DateTime::createFromFormat('Y-m-d', $this->year . '-12-25');
        $this->endDate = \DateTime::createFromFormat('Y-m-d', $this->year . '-12-25');
        $this->totalLength = 1;
    }
}