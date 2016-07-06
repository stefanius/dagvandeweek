<?php

namespace Stefanius\DagVanDeWeekBundle\Twig\Extension;

class IsLeapYearExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('leap', array($this, 'isLeapYearFilter')),
        );
    }

    /**
     * @param $year
     *
     * @return bool
     */
    public function isLeapYearFilter($year)
    {
        if ($this->isInteger($year / 400)) {
            return true; // possible leapyear is the year 2000 or any other year thad could be diveded bij 400
        } elseif ($this->canDividedByFour($year) && !$this->isCentury($year)) {
            return true; //A year dived by 4 AND is NOT a century year (like 1900 or 1700)
        }

        return false;
    }

    /**
     * @param $number
     *
     * @return bool
     */
    protected function isEven($number)
    {
        return $number % 2 === 0;
    }

    /**
     * @param $number
     *
     * @return bool
     */
    protected function isInteger($number)
    {
        return is_integer($number);
    }

    /**
     * @param $number
     * 
     * @return bool
     */
    protected function canDividedByFour($number)
    {
        return $number % 4 === 0;
    }

    /**
     * @param $number
     *
     * @return bool
     */
    protected function isCentury($number)
    {
        $result = preg_match('/^([0-9])([0-9])([0])([0])$/', $number, $matchs) === 1;

        return $result;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'is_leap_year_extension';
    }
}
