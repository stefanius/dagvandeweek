<?php

namespace Stef\DagVanDeWeekBundle\BreadcrumbGenerator;


class HistoryTitleBuilder implements TitleBuilderInterface
{
    /**
     * @param string $title
     * @param integer $elementIndex
     *
     * @return string
     */
    public function build($title, $elementIndex)
    {
        switch($elementIndex) {
            case 3:
                $title = 'Geschiedenis ' . $title;
                break;
            default:
                $title = ucfirst($title);
        }

        return $title;
    }

}