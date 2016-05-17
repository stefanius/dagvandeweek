<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Stef\DagVanDeWeekBundle\Date\DateObjectFactory;
use Stefanius\SimpleCmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MonthController extends BaseController
{
    /**
     * @param Request $request
     * @param $dutchMonthName
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function showMonthAction(Request $request, $dutchMonthName)
    {
        $factory = new DateObjectFactory();
        $monthNumber    = $factory->getConvertedMonthNumber($dutchMonthName);

        $specialDates = $this->findSpecialDatesByMonth(2016, $monthNumber);

        $manager   = $this->getHistoryManager();
        $histories = $manager->findByMonth($monthNumber);

        $page = new Page();

        $page->setTitle('Maandoverzicht ' . $dutchMonthName);

        $page->setDescription('Maandoverzicht ' . $dutchMonthName . '. Wij hebben ' . count($histories) . ' gebeurtenissen gevonden voor de maand ' . $dutchMonthName);

        return $this->render('StefDagVanDeWeekBundle:Month:index.html.twig', [
                'year'           => 2016,
                'page'           => $page,
                'histories'      => $histories,
                'monthNumber'    => $monthNumber,
                'specialDates'   => $specialDates,
                'dutchMonthName' => $dutchMonthName,
            ]
        );
    }
}
