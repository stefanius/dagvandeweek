<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Stef\DagVanDeWeekBundle\Date\DateObjectFactory;
use Stef\SimpleCmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TodayInThePastController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function showTodayAction(Request $request)
    {
        $today = new \DateTime();
        $factory = new DateObjectFactory();
        $date    = $factory->createByDateTime($today);

        $manager   = $this->getHistoryManager();
        $histories = $manager->findByDayMonth($date->getDay(), $date->getMonthNumber());

        $page = new Page();
        $page->setTitle('Vandaag in het verleden');
        $page->setDescription('De dag van vandaag heeft een verleden. Bekijk hier de datum van vandaag en duik in het verleden van ' . $date->getDay(). ' ' . $date->getTranslatedMonthName());

        return $this->render('StefDagVanDeWeekBundle:TodayInThePast:index.html.twig', [
                'page'      => $page,
                'histories' => $histories,
                'date'      => $date,
            ]
        );
    }
}
