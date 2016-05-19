<?php

namespace Stefanius\DagVanDeWeekBundle\Controller;

use Stefanius\DagVanDeWeekBundle\CalendarTranslations\Dutch;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SitemapController extends BaseController
{
    public function generateAction(Request $request, $mappingKey)
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/xml');

        $records = null;

        if ($mappingKey === 'page') {
            $records = $this->getPageManager()->getAllRecords();
        } elseif ($mappingKey === 'history') {
            $records = $this->getHistoryManager()->getAllRecords();
        } elseif ($mappingKey === 'day') {
            $records = $this->getDayManager()->getAllRecords();
        }

        if ($records === null || !is_array($records) || count($records) == 0) {
            $this->redirect('/');
        }

        return $this->render('StefaniusDagVanDeWeekBundle:Sitemap:' . $mappingKey . '.xml.twig', [
                'records' => $records,
            ],
            $response
        );
    }

    public function generateByMonthAction(Request $request, $month)
    {
        $months = new Dutch();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/xml');

        $number = $months->getMonthNumberByName($month);

        if ($number > 0) {
            $records = $this->getHistoryManager()->findByMonth($number);

            return $this->render('StefaniusDagVanDeWeekBundle:Sitemap:history.xml.twig', [
                'records' => $records,
            ],
                $response
            );
        }

        return $this->redirect('/');
    }

    public function generateByMonthPerDayAction(Request $request, $month)
    {
        $months = new Dutch();
        $response = new Response();
        $response->headers->set('Content-Type', 'application/xml');

        $number = $months->getMonthNumberByName($month);

        if ($number > 0) {
            $records = $this->getHistoryManager()->getActiveDays($number);

            return $this->render('StefaniusDagVanDeWeekBundle:Sitemap:activedays.xml.twig', [
                'records' => $records,
                'dutchMonthName' => $month,
            ],
                $response
            );
        }

        return $this->redirect('/');
    }
}
