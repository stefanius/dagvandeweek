<?php

namespace Stefanius\DagVanDeWeekBundle\CalendarTranslations;

interface TranslatorInterface
{
    /**
     * @param $number
     *
     * @return string
     */
    public function getMonth($number);

    /**
     * @param $number
     *
     * @return string
     */
    public function getDay($number);

    /**
     * @param string $name
     * @param bool   $leadingZero
     *
     * @return int
     */
    public function getMonthNumberByName($name, $leadingZero = true);
}
