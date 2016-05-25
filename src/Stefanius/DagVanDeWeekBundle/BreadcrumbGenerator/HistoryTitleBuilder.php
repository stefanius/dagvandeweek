<?php

namespace Stefanius\DagVanDeWeekBundle\BreadcrumbGenerator;

use Carbon\Carbon;

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
                $title = 'Overzicht ' . Carbon::createFromDate(1984, $title)->formatLocalized('%B') . ' ' . $path[2];
                break;
            case 5:
                $date = Carbon::createFromDate($path[2], $path[3], $path[4]);

                $title = ucfirst($date->formatLocalized('%A')) . ' ' . (int) $title . ' ' . $date->formatLocalized('%B') . ' ' . $path[2];
                break;
            default:
                $title = ucfirst($title);
        }

        return $title;
    }
}
