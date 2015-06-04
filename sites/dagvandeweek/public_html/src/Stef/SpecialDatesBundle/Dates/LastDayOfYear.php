<?php

namespace Stef\SpecialDatesBundle\Dates;

class LastDayOfYear extends AbstractSpecialDate
{
    protected function generate()
    {
        $this->description = 'Oudjaarsdag';

        $this->startDate   = \DateTime::createFromFormat('Y-m-d', $this->year . '-12-31');
        $this->endDate     = \DateTime::createFromFormat('Y-m-d', $this->year . '-12-31');
        $this->totalLength = 1;
    }
}
