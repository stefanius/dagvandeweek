<?php

namespace Stef\DagVanDeWeekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Stef\SimpleCmsBundle\Entity\AbstractCmsContent;

/**
 * @ORM\Entity
 */
class History extends AbstractCmsContent
{
    /**
     * @ORM\Column(type="integer")
     */
    protected $year;

    /**
     * @ORM\Column(type="integer")
     */
    protected $month;

    /**
     * @ORM\Column(type="integer")
     */
    protected $day;

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param mixed $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }
}