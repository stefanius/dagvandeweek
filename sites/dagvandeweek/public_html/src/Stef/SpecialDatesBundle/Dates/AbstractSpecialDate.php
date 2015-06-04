<?php

namespace Stef\SpecialDatesBundle\Dates;

abstract class AbstractSpecialDate implements SpecialDateInterface
{
    /**
     * @var \DateTime
     */
    protected $startDate;

    /**
     * @var \DateTime
     */
    protected $endDate;

    /**
     * @var \DateTime
     */
    protected $zeroDate;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var int
     */
    protected $totalLength = 0;

    /**
     * @var bool
     */
    protected $valid = true;

    /**
     * @var int
     */
    protected $year;

    public function __construct($year)
    {
        $this->year     = $year;
        $this->zeroDate = new \DateTime();
        $this->zeroDate->setDate(0, 0, 0);
        $this->generate();
    }

    public function getStartDate()
    {
        if (!$this->valid || $this->startDate == null) {
            return $this->zeroDate;
        }

        return $this->startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        if (!$this->valid || $this->endDate == null) {
            return $this->zeroDate;
        }

        return $this->endDate;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return int
     */
    public function getTotalLength()
    {
        return $this->totalLength;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->valid;
    }

    abstract protected function generate();
}
