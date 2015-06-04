<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Symfony\Component\HttpFoundation\ParameterBag;

class PageController extends BaseController
{
    public function showAction($slug)
    {
        $extra = [];

        $page = $this->getPageManager()->read($slug);

        //Temp, until Manipulation accepts NULL values
        if ($page->getKvSettings() !== null && is_string($page->getKvSettings())) {
            $pageOptions = $this->getKeyValueParser()->parseKeyValuesToParameterBag($page->getKvSettings());
        } else {
            $pageOptions = new ParameterBag();
        }

        $twig = $page->getTwig();

        if (empty($twig)) {
            $twig = 'StefDagVanDeWeekBundle:Default:page.html.twig';
        }

        return $this->render($twig, array_merge($extra, [
                'page' => $page,
                'pageOptions' => $pageOptions->all(),
                'auth' => $this->isAuthenticatedFully(),
            ])
        );
    }
}
