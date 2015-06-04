<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Stef\DagVanDeWeekBundle\Date\DateObjectFactory;
use Stef\DagVanDeWeekBundle\Entity\Day;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DayByDayController extends BaseController
{
    /**
     * @param Request $request
     * @param $day
     * @param $dutchMonthName
     *
     * @return Response
     */
    public function showTodayAction(Request $request, $day, $dutchMonthName)
    {
        $factory = new DateObjectFactory();
        $date    = $factory->createByConvertedMonthDay($dutchMonthName, $day);

        if ((integer) $date->getDay() !== (integer) $day && (integer) $day > 0 && $date->getDay() > 0) {
            return $this->redirect($this->generateUrl($request->get('_route'), [
                'day'            => (integer) $date->getDay(),
                'dutchMonthName' => $date->getTranslator()->getMonth($date->getMonthNumber() + 1),
            ]));
        }

        $dayBefore = $date->getDayBefore();
        $dayAfter  = $date->getDayAfter();

        $manager   = $this->getHistoryManager();
        $histories = $manager->findByDayMonth($day, $date->getMonthNumber());

        $page = $this->getDayManager()->findByDayAndMonth($date->getDay(), $date->getMonthNumber());

        if ($page == null) {
            $page = new Day();
        }

        if ($page->getTitle() == null) {
            $page->setTitle($day . ' ' . $dutchMonthName . ' in het verleden');
        }

        if ($page->getDescription() == null) {
            $page->setDescription((integer) $day . ' ' . $dutchMonthName . ' is de ' . (integer) $day . 'e dag uit de ' . $date->getMonthNumber() . 'e maand. Bekijk hier een overzicht van gebeurtenissen op deze dag van het jaar!');
        }

        return $this->render('StefDagVanDeWeekBundle:DayByDay:index.html.twig', [
                'date'      => $date,
                'dayAfter'  => $dayAfter,
                'dayBefore' => $dayBefore,
                'page'      => $page,
                'day'       => $day,
                'histories' => $histories,
            ]
        );
    }
}
