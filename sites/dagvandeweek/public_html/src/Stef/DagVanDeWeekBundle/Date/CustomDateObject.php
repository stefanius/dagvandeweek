<?php

namespace Stef\DagVanDeWeekBundle\Date;

use Stef\DagVanDeWeekBundle\CalendarTranslations\TranslatorInterface;

class CustomDateObject
{
    /**
     * @var \DateTime
     */
    protected $dateTime;

    /**
     * @var int
     */
    protected $year;

    /**
     * @var int
     */
    protected $day;

    /**
     * @var int
     */
    protected $weekDayNumber;

    /**
     * @var int
     */
    protected $yearDayNumber;

    /**
     * @var int
     */
    protected $monthNumber;

    /**
     * @var int
     */
    protected $weekNumber;

    /**
     * @var int
     */
    protected $lastDayOfMonth;

    /**
     * @var int
     */
    protected $unixSeconds;

    /**
     * @var string
     */
    protected $translatedMonthName;

    /**
     * @var string
     */
    protected $translatedWeekdayName;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    function __construct(\DateTime $dateTime, TranslatorInterface $translator)
    {
        $this->dateTime = $dateTime;
        $this->translator = $translator;

        $this->convert();
    }

    protected function convert()
    {
        $this->year = $this->dateTime->format("Y");
        $this->day = $this->dateTime->format("d");
        $this->weekDayNumber = $this->dateTime->format("w");
        $this->monthNumber = $this->dateTime->format("m");
        $this->yearDayNumber = $this->dateTime->format("z") + 1;
        $this->weekNumber = $this->dateTime->format("W");
        $this->lastDayOfMonth = $this->dateTime->format("t");
        $this->unixSeconds = $this->dateTime->format("U");
        $this->translatedMonthName = $this->translator->getMonth($this->monthNumber);
        $this->translatedWeekdayName = $this->translator->getDay($this->weekDayNumber);
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @return int
     */
    public function getWeekDayNumber()
    {
        return $this->weekDayNumber;
    }

    /**
     * @return int
     */
    public function getYearDayNumber()
    {
        return $this->yearDayNumber;
    }

    /**
     * @return int
     */
    public function getWeekNumber()
    {
        return $this->weekNumber;
    }

    /**
     * @return int
     */
    public function getLastDayOfMonth()
    {
        return $this->lastDayOfMonth;
    }

    /**
     * @return int
     */
    public function getUnixSeconds()
    {
        return $this->unixSeconds;
    }

    /**
     * @return string
     */
    public function getTranslatedMonthName()
    {
        return $this->translatedMonthName;
    }

    /**
     * @return string
     */
    public function getTranslatedWeekdayName()
    {
        return $this->translatedWeekdayName;
    }

    /**
     * @return int
     */
    public function getMonthNumber()
    {
        return $this->monthNumber;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @return TranslatorInterface
     */
    public function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @return CustomDateObject
     */
    public function getDayAfter()
    {
        $dayAfter = $this->dateTime;
        $dayAfter->modify('+1 day');

        return new CustomDateObject($dayAfter, $this->translator);
    }

    /**
     * @return CustomDateObject
     */
    public function getDayBefore()
    {
        $dayBefore = $this->dateTime;
        $dayBefore->modify('-1 day');

        return new CustomDateObject($dayBefore, $this->translator);
    }
}