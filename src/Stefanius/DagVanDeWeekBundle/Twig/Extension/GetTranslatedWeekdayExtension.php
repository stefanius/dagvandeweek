<?php

namespace Stefanius\DagVanDeWeekBundle\Twig\Extension;

use Stefanius\DagVanDeWeekBundle\CalendarTranslations\Dutch;

class GetTranslatedWeekdayExtension extends \Twig_Extension
{
    /**
     * @var Dutch
     */
    protected $translations;

    /**
     * @param Dutch $translations
     */
    public function __construct(Dutch $translations = null)
    {
        if ($translations === null) {
            $translations = new Dutch(); //Will be refactored later on.
        }

        $this->translations = $translations;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('translate_weekday', array($this, 'getTranslated')),
        );
    }

    /**
     * @param $number
     *
     * @return mixed
     */
    public function getTranslated($number)
    {
        return $this->translations->getDay($number);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'translated_weekday_extension';
    }
}
