<?php

namespace Stef\DagVanDeWeekBundle\CalendarTranslations;

class Dutch
{

    protected $months = [];

    protected $weekdays = [];

    function __construct()
    {
        $this->months['01'] = 'januari';
        $this->months['02'] = 'februarie';
        $this->months['03'] = 'maart';
        $this->months['04'] = 'april';
        $this->months['05'] = 'mei';
        $this->months['06'] = 'juni';
        $this->months['07'] = 'juli';
        $this->months['08'] = 'augustus';
        $this->months['09'] = 'september';
        $this->months['10'] = 'oktober';
        $this->months['11'] = 'november';
        $this->months['12'] = 'december';
    }

    public function getMonth($number)
    {
        if (strlen($number) < 2) {
            $number = '0' . $number;
        }

        return $this->months[$number];
    }
}