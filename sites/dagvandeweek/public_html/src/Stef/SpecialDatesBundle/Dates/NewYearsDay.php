<?php

namespace Stef\SpecialDatesBundle\Dates;

class NewYearsDay extends AbstractSpecialDate
{
    protected function generate()
    {
        $this->startDate = \DateTime::createFromFormat('Y-m-d', $this->year . '-1-1');
        $this->endDate = \DateTime::createFromFormat('Y-m-d', $this->year . '-1-1');
        $this->totalLength = 1;
    }
}