<?php

namespace Stef\DagVanDeWeekBundle\CalendarTranslations;

abstract class AbstractTranslator implements TranslatorInterface
{
    protected $months = [];

    protected $weekdays = [];

    /**
     * @param $number
     * @param $leadingZero
     * @return int|string
     */
    protected function formatNumber($number, $leadingZero)
    {
        if (!is_numeric($number)) {
            return 0;
        }

        if ($leadingZero === false) {
            return ltrim($number, '0');
        }

        if (strlen($number) === 1 && $number < 10) {
            return '0' . $number;
        }

        return $number;
    }

    /**
     * @param $number
     * @return string
     */
    public function getMonth($number)
    {
        if (strlen($number) < 2) {
            $number = '0' . $number;
        }

        return $this->months[$number];
    }

    /**
     * @param $number
     * @return string
     */
    public function getDay($number)
    {
        return $this->weekdays[(integer) $number];
    }

    /**
     * @param $name
     * @param bool $leadingZero
     * @return int
     */
    public function getMonthNumberByName($name, $leadingZero = true)
    {
        foreach ($this->months as $key => $value) {
            if ($value === $name) {
                return $this->formatNumber($key, $leadingZero);
            }
        }

        return 0;
    }
}