<?php

namespace Stef\DagVanDeWeekBundle\BreadcrumbGenerator;


use Stef\DagVanDeWeekBundle\CalendarTranslations\Dutch;

class HistoryTitleBuilder implements TitleBuilderInterface
{
    /**
     * @var Dutch
     */
    protected $calenderTranslation;

    function __construct($calenderTranslation)
    {
        $this->calenderTranslation = $calenderTranslation;
    }

    /**
     * {@inheritdoc}
     */
    public function build($title, $elementIndex, $path = null)
    {
        switch($elementIndex) {
            case 3:
                $title = 'Geschiedenis ' . $title;
                break;
            case 4:
                $title = 'Overzicht ' . $this->calenderTranslation->getMonth($title) . ' ' . $path[2];
                break;
            case 5:
                $date = new \DateTime();
                $date->setDate($path[2], $path[3], $path[4]);

                $title = ucfirst($this->calenderTranslation->getDay($date->format('w'))) . ' ' . (int)$title . ' ' . $this->calenderTranslation->getMonth($path[3]) . ' ' . $path[2];
                break;
            default:
                $title = ucfirst($title);
        }

        return $title;
    }

}