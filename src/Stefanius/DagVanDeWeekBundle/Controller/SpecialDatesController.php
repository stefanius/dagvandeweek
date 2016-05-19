<?php

namespace Stefanius\DagVanDeWeekBundle\Controller;

use Stefanius\SimpleCmsBundle\Entity\Page;
use Stefanius\SpecialDates\DateParser\Parser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SpecialDatesController extends BaseController
{
    /**
     * @param Request $request
     * @param $year
     *
     * @return Response
     */
    public function showAction(Request $request, $year)
    {
        $parser = new Parser();
        $dates  = $parser->getAllValidDates($year);
        $page   = new Page();

        $page->setTitle('Bijzondere dagen ' . $year);
        $page->setDescription($year . ' heeft een groot aantal bijzondere dagen. Wij hebben er ' . count($dates) . ' verzameld! Bekijk hier het overzicht van bijzondere dagen uit ' . $year . '!');
        $page->setRobotsIndex(false);

        if ($year === 2015 || $year === '2015') {
            $page->setRobotsIndex(true);
        }

        $twig = 'StefaniusDagVanDeWeekBundle:SpecialDates:year.html.twig';

        return $this->render($twig, [
            'dates' => $dates,
            'year'  => $year,
            'page'  => $page,
        ]);
    }
}
