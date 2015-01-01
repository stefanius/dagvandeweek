<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Proxies\__CG__\Stef\DagVanDeWeekBundle\Entity\History;
use Stef\DagVanDeWeekBundle\CalendarTranslations\Dutch;
use Stef\DagVanDeWeekBundle\Entity\HistoryYear;
use Stef\SimpleCmsBundle\Entity\Page;

class HistoryController extends BaseController
{
    protected function buildHistoryPage($year)
    {
        $page = $this->getHistoryYearManager()->read($year);

        if ($page === null) {
            $page = new HistoryYear();
            $page->setTitle($year);
            $page->setYear($year);
            $page->setSlug($year);

            if ($year < date("Y")) {
                $p1 = "<p>Het jaar " . $year . " ligt alweer " . (date("Y") - $year) . " jaar achter ons. Er is in dat jaar veel gebeurt en wij willen dat graag met jou delen! Elke dag van de week is beinvloed door de dagen van voorgaande weken. OF iets nu gisteren of vorgie week is gebeurt. Vorig jaar of 400 jaar geleden. Wij zoeken het uit. En delen het met jou! Elke dag opnieuw. Wat vandaag in het nieuws is, is morgen geschiedenis!</p>";

                $page->setBody($p1);
            } else {
                $p1 = "<p>Deze pagina's gaan over de geschiedenis. Ons verleden. Het jaar " . $year . " laat nog " . ($year - date("Y")) . " jaar op zich wachten. Het is dus zeer aannemelijk dat wij nog niet beschikken over enorme hoeveelheden gebeurtenissen uit het jaar " . $year . ". Wellicht ben je wel geintreseerd in de " . '<a href="http://dagvandeweek.nl/kalender/' . $year . '">kalender</a> uit de (verre) toekomst?</p>';

                $page->setBody($p1);
            }
        }

        return $page;
    }

    protected function createDayInfo($year, $month, $day)
    {
        $translation = new Dutch();
        $date = new \DateTime($year . '-' . $month . '-' . $day);

        $weekDayNumber = $date->format("w");
        $yearDayNumber = $date->format("z");
        $weekNumber = $date->format("W");
        $unixSeconds = $date->format("U");
        $dutchMonthName = $translation->getMonth($month);
        $dutchWeekdayName = $translation->getDay($day);

        return [
            'weekDayNumber' => $weekDayNumber,
            'yearDayNumber' => $yearDayNumber,
            'weekNumber' => $weekNumber,
            'unixSeconds' => $unixSeconds,
            'dutchMonthName' => $dutchMonthName,
            'dutchWeekdayName' => $dutchWeekdayName,
        ];
    }

    public function showByYearAction($year)
    {
        $page = $this->buildHistoryPage($year);
        $items = $this->getHistoryManager()->findByYear($year);

        return $this->render('StefDagVanDeWeekBundle:History:year.html.twig', [
            'page' => $page,
            'items' => $items
        ]);
    }

    public function showByYearMonthAction($year, $month)
    {
        $page = $this->buildHistoryPage($year);
        $items = $this->getHistoryManager()->findByMonthYear($month, $year);

        $page->setRobotsIndex(false);
        $page->setRobotsFollow(true);

        return $this->render('StefDagVanDeWeekBundle:History:year.html.twig', [
            'page' => $page,
            'items' => $items,
            'month' => $month
        ]);
    }

    public function showByYearMonthDayAction($year, $month, $day)
    {
        $items = $this->getHistoryManager()->findByDayMonthYear($day, $month, $year);
        $dayInfo = $this->createDayInfo($year, $month, $day);

        $page = new History();
        $page->setDay($day);
        $page->setMonth($month);
        $page->setYear($year);
        $page->setTitle(ucfirst($dayInfo['dutchWeekdayName']) . ' ' . $day . ' ' . $dayInfo['dutchMonthName'] . ' ' . $year);

        $page->setRobotsIndex(false);
        $page->setRobotsFollow(true);

        return $this->render('StefDagVanDeWeekBundle:History:day.html.twig', [
            'page' => $page,
            'items' => $items,
            'month' => $month,
            'dayInfo' => $dayInfo
        ]);
    }

    public function showArticleAction($year, $month, $day, $slug)
    {
        $page = $this->getHistoryManager()->findByDayMonthYearSlug($day, $month, $year, $slug);
        $dayInfo = $this->createDayInfo($year, $month, $day);

        return $this->render('StefDagVanDeWeekBundle:History:article.html.twig', [
            'page' => $page,
            'dayInfo' => $dayInfo
        ]);
    }

    public function showIndexAction()
    {
        $latestItems = $this->getHistoryManager()->getLatestEntries(10);
        $years = $this->getHistoryManager()->getActiveYears();
        $page = new Page();
        $page->setTitle("Historisch Jaaroverzicht");
        $page->setDescription("DagVanDeWeek heeft een uitgebreide database met gegevens. Hier kan je (bijna) alles vinden wat je wilt! Voor je werkstuk, spreekbeurt of gewoon omdat je het WILT weten! Elke dag van de week is er weer een dag bij in de geschiedenis!");

        return $this->render('StefDagVanDeWeekBundle:History:index.html.twig', [
            'latestItems' => $latestItems,
            'years' => $years,
            'page' => $page
        ]);
    }
}
