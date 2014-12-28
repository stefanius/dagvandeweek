<?php

namespace Stef\DagVanDeWeekBundle\Twig\Extension;

use Stef\DagVanDeWeekBundle\CalendarTranslations\Dutch;

class GetTranslatedMonthExtension extends \Twig_Extension
{
    /**
     * @var Dutch
     */
    protected $translations;

    /**
     * @param Dutch $translations
     */
    function __construct(Dutch $translations = null)
    {
        if ($translations === null) {
            $translations = new Dutch(); //Will be refactored later on.
        }

        $this->translations = $translations;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('translate_month', array($this, 'getTranslated')),
        );
    }

    /**
     * @param $number
     * @return mixed
     */
    public function getTranslated($number)
    {
        return $this->translations->getMonth($number);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'translated_month_extension';
    }
}