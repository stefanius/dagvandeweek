<?php

namespace Stef\DagVanDeWeekBundle\BreadcrumbGenerator;


interface TitleBuilderInterface {

    /**
     * @param string $title
     * @param integer $elementIndex
     *
     * @return string
     */
    public function build($title, $elementIndex);
}