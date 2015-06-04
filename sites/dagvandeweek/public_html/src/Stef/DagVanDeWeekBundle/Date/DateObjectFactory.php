<?php

namespace Stef\DagVanDeWeekBundle\Date;

use Stef\DagVanDeWeekBundle\CalendarTranslations\Dutch;
use Stef\DagVanDeWeekBundle\CalendarTranslations\TranslatorInterface;

class DateObjectFactory
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    public function __construct()
    {
        $this->translator = new Dutch();
    }

    /**
     * @param \DateTime $date
     *
     * @return CustomDateObject
     */
    public function createByDateTime(\DateTime $date)
    {
        return new CustomDateObject($date, $this->translator);
    }

    /**
     * Create a CustomDateObject by an exact date. The month must be an integer from 1 to 12.
     *
     * @param $year
     * @param $month
     * @param $day
     *
     * @return CustomDateObject
     */
    public function createByYearMonthDay($year, $month, $day)
    {
        $date = new \DateTime($year . '-' . $month . '-' . $day);

        return $this->createByDateTime($date);
    }

    /**
     * Create a CustomDateObject. We use the current year. The month must be an integer from 1 to 12.
     *
     * @param $month
     * @param $day
     *
     * @return CustomDateObject
     */
    public function createByMonthDay($month, $day)
    {
        $today = new \DateTime();
        $date = new \DateTime($today->format('Y') . '-' . $month . '-' . $day);

        return $this->createByDateTime($date);
    }

    /**
     * Create a CustomDateObject by an exact date. The month must be a a string which is known in the Date translation classes.
     *
     * @param $year
     * @param $monthName
     * @param $day
     *
     * @return CustomDateObject
     */
    public function createByYearConvertedMonthDay($year, $monthName, $day)
    {
        $month = $this->translator->getMonthNumberByName($monthName);
        $date = new \DateTime($year . '-' . $month . '-' . $day);

        return $this->createByDateTime($date);
    }

    /**
     * Create a CustomDateObject. We use the current year. The month must be a a string which is known in the Date translation classes.
     *
     * @param $monthName
     * @param $day
     *
     * @return CustomDateObject
     */
    public function createByConvertedMonthDay($monthName, $day)
    {
        $month = $this->translator->getMonthNumberByName($monthName);

        if ((integer) $day === 29 && (integer) $month === 2) {
            $year = 2016;
        } else {
            $today = new \DateTime();
            $year = $today->format('Y');
        }

        $date = new \DateTime($year . '-' . $month . '-' . $day);

        return $this->createByDateTime($date);
    }
}
