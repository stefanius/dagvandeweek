<?php

namespace Stefanius\DagVanDeWeekBundle\BreadcrumbGenerator;

class HistoryTitleBuilder implements TitleBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function build($title, $elementIndex, $path = null)
    {
        switch ($elementIndex) {
            case 3:
                $title = 'Geschiedenis ' . $title;
                break;
            case 4:
                $title = 'Overzicht ' . $this->calenderTranslation->getMonth($title) . ' ' . $path[2];
                break;
            case 5:
                $date = new \DateTime();
                $date->setDate($path[2], $path[3], $path[4]);

                $title = ucfirst($this->calenderTranslation->getDay($date->format('w'))) . ' ' . (int) $title . ' ' . $this->calenderTranslation->getMonth($path[3]) . ' ' . $path[2];
                break;
            default:
                $title = ucfirst($title);
        }

        return $title;
    }
}
