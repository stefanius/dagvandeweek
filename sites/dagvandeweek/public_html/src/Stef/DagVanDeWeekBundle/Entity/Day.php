<?php

namespace Stef\DagVanDeWeekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Stef\SimpleCmsBundle\Entity\AbstractCmsContent;

/**
 * Day.
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="unique_day_month", columns={"day", "month"})})
 * @ORM\Entity
 */
class Day extends AbstractCmsContent
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $title;

    /**
     * @var int
     *
     * @ORM\Column(name="day", type="integer", length=255)
     */
    protected $day;

    /**
     * @var int
     *
     * @ORM\Column(name="month", type="integer", length=255)
     */
    protected $month;

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param int $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @return int
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @param int $month
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }
}
