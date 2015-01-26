<?php

namespace Stef\DagVanDeWeekBundle\BreadcrumbGenerator;


interface TitleBuilderInterface {

    /**
     * @param $title
     * @param $elementIndex
     * @param null $path
     *
     * @return mixed
     */
    public function build($title, $elementIndex, $path = null);
}