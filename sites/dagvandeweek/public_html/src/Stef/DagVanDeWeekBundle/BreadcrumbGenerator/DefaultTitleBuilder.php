<?php

namespace Stef\DagVanDeWeekBundle\BreadcrumbGenerator;


class DefaultTitleBuilder implements TitleBuilderInterface
{
    /**
     * @param string $title
     * @param integer $elementIndex
     *
     * @return string
     */
    public function build($title, $elementIndex)
    {
        return ucfirst($title);
    }

}