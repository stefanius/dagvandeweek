<?php

namespace Stefanius\DagVanDeWeekBundle\BreadcrumbGenerator;

class CalendarTitleBuilder implements TitleBuilderInterface
{
    /**
     * {@inheritdoc}
     */
    public function build($title, $elementIndex, $path = null)
    {
        switch ($elementIndex) {
            case 2:
                $title = 'Jaarkalenders';
                break;
            default:
                $title = ucfirst($title);
        }

        return $title;
    }
}
