<?php

namespace Stef\DagVanDeWeekBundle\CalendarTranslations;


interface TranslatorInterface
{
    /**
     * @param $number
     * @return string
     */
    public function getMonth($number);

    /**
     * @param $number
     * @return string
     */
    public function getDay($number);

    /**
     * @param $name
     * @param bool $leadingZero
     * @return int
     */
    public function getMonthNumberByName($name, $leadingZero = true);
}