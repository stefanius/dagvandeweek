<?php

namespace Stefanius\DagVanDeWeekBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Stefanius\SimpleCmsBundle\Entity\AbstractCmsContent;

abstract class AbstractYear extends AbstractCmsContent
{
    /**
     * @ORM\Column(type="string")
     */
    protected $year;

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param string $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }
}
