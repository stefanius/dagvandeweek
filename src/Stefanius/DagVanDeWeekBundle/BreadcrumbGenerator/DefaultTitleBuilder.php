<?php

namespace Stefanius\DagVanDeWeekBundle\BreadcrumbGenerator;

class DefaultTitleBuilder implements TitleBuilderInterface
{
    /**
     * @param $title
     * @param $elementIndex
     * @param null $path
     *
     * @return string
     */
    public function build($title, $elementIndex, $path = null)
    {
        return ucfirst($title);
    }
}
