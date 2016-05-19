<?php

namespace Stefanius\DagVanDeWeekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Stefanius\SimpleCmsBundle\Entity\AbstractCmsContent;

/**
 * @ORM\Entity
 */
class WeekHero extends AbstractCmsContent
{
    /**
     * @ORM\Column(type="integer")
     */
    protected $year;

    /**
     * @ORM\Column(type="integer")
     */
    protected $week;

    /**
     * @return mixed
     */
    public function getWeek()
    {
        return $this->week;
    }

    /**
     * @param mixed $week
     */
    public function setWeek($week)
    {
        $this->week = $week;
    }

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
}
