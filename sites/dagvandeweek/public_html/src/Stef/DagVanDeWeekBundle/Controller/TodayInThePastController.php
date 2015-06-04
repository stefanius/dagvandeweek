<?php

namespace Stef\DagVanDeWeekBundle\Controller;

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
        $year = $today->format('Y');
        $month = $today->format('m');
        $day = $today->format('d');

        $manager = $this->getHistoryManager();
        $histories = $manager->findByDayMonth($day, $month);

        $dayinfo = $this->createDayInfo($year, $month, $day);

        $page = new Page();
        $page->setTitle('Vandaag in het verleden');
        $page->setDescription('De dag van vandaag heeft een verleden. Bekijk hier de datum van vandaag en duik in het verleden van ' . $day . ' ' . $dayinfo['dutchMonthName']);

        return $this->render('StefDagVanDeWeekBundle:TodayInThePast:index.html.twig', array_merge($dayinfo, [
                'page' => $page,
                'year' => $year,
                'month' => $month,
                'day' => $day,
                'histories' => $histories,
            ])
        );
    }
}
