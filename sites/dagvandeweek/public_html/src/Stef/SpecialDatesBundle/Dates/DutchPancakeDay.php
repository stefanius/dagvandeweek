<?php

namespace Stef\SpecialDatesBundle\Dates;

class DutchPancakeDay extends AbstractSpecialDate
{
    protected function generate()
    {
        if ($this->year >= 2007) {
            $timestamp = strtotime('last friday', mktime(0,0,0,4,0,$this->year));
            $this->startDate = new \DateTime();
            $this->startDate->setTimestamp($timestamp);
            $this->endDate = new \DateTime();
            $this->endDate->setTimestamp($timestamp);
            $this->totalLength = 1;
        } else {
            $this->valid = false;
        }
    }
}