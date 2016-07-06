<?php

namespace Stefanius\DagVanDeWeekBundle\Twig\Extension;

class IsCenturyYearExtension extends \Twig_Extension
{
    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('century', array($this, 'isCenturyYearFilter')),
        );
    }

    /**
     * @param $year
     *
     * @return bool
     */
    public function isCenturyYearFilter($year)
    {
        return $this->isCentury($year);
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
        return 'is_century_year_extension';
    }
}
