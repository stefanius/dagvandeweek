<?php

namespace Stefanius\DagVanDeWeekBundle\Controller;

use Symfony\Component\HttpFoundation\ParameterBag;

class PageController extends BaseController
{
    public function showAction($slug)
    {
        $extra = [];

        $page = $this->getPageManager()->read($slug);

        $pageOptions = new ParameterBag();

        $twig = $page->getTwig();

        if (empty($twig)) {
            $twig = 'StefaniusDagVanDeWeekBundle:Default:page.html.twig';
        }

        return $this->render($twig, array_merge($extra, [
                'page'        => $page,
                'pageOptions' => $pageOptions->all(),
                'auth'        => $this->isAuthenticatedFully(),
            ])
        );
    }
}
