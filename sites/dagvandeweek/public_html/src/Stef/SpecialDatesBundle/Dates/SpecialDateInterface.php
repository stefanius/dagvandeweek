<?php

namespace Stef\SpecialDatesBundle\Dates;

interface SpecialDateInterface
{
    public function getStartDate();

    public function getEndDate();

    public function getDescription();

    public function getTotalLength();

    public function isValid();
}
