<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Stef\DagVanDeWeekBundle\Entity\History;
use Stef\DagVanDeWeekBundle\CalendarTranslations\Dutch;
use Stef\DagVanDeWeekBundle\Entity\HistoryYear;
use Stef\SimpleCmsBundle\Entity\AbstractCmsContent;
use Stef\SimpleCmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\Request;

class HistoryController extends BaseController
{
    protected function buildHistoryPage($year)
    {
        $page = $this->getHistoryYearManager()->read($year);

        if ($page === null) {
            $page = new HistoryYear();
            $page->setTitle('Historie ' . $year);
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

        if ($page->getTitle() == $year && strlen($page->getTitle()) < 5) {
            $page->setTitle('Historie ' . $page->getYear() );
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
        $dutchWeekdayName = $translation->getDay($weekDayNumber);

        return [
            'weekDayNumber' => $weekDayNumber,
            'yearDayNumber' => $yearDayNumber,
            'weekNumber' => $weekNumber,
            'unixSeconds' => $unixSeconds,
            'dutchMonthName' => $dutchMonthName,
            'dutchWeekdayName' => $dutchWeekdayName,
        ];
    }

    /**
     * @param null $year
     * @param null $month
     * @param null $day
     * @param null $slug
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    protected function internalRedirect($year = null, $month = null, $day = null, $slug = null)
    {
        if ($year == null) {
            return $this->redirect('/historie/');
        }

        if ($month == null) {
            return $this->redirect('/historie/' . $year);
        }

        if ($day == null) {
            return $this->redirect('/historie/' . $year . '/' . sprintf('%1$02d', $month));
        }

        if ($slug == null) {
            return $this->redirect('/historie/' . $year . '/' . sprintf('%1$02d/%1$02d', $month, $day));
        }

        return $this->redirect('/historie/' . $year . '/' . sprintf('%1$02d/%1$02d', $month, $day) . '/' . $slug);
    }

    public function showByYearAction($year)
    {
        $page = $this->buildHistoryPage($year);
        $items = $this->getHistoryManager()->findByYear($year);

        if (count($items) == 0) {
            $page->setRobotsIndex(false);
        }

        return $this->render('StefDagVanDeWeekBundle:History:year.html.twig', [
            'page' => $page,
            'items' => $items
        ]);
    }

    public function showByYearMonthAction($year, $month)
    {
        if (strlen($month) < 2) {
            return $this->internalRedirect($year, $month);
        }

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
        if (strlen($month) < 2 || strlen($day) < 2) {
            return $this->internalRedirect($year, $month, $day);
        }

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

    protected function generateBreadCrumbs(Request $request, AbstractCmsContent $page = null)
    {
        $breadcrumbs = $this->getWhiteOctoberBreadcrumbs();
        $url = trim($request->getRequestUri(), '/');
        $explode = explode('/', $url);

        if ($explode[0] !== trim($request->getBaseUrl(), '/')) {
            array_unshift($explode, '/');
        } else {
            $explode[0] = '/' . $explode[0];
        }

        $path = [];
        $i = 0;

        foreach ($explode as $p) {
            $path[] = $p;
            $crumblink = '/' . trim(implode('/', $path), '/');
            $i++;

            if (count($path) === 1) {
                $breadcrumbs->addItem('Home', $crumblink);
            } elseif ($i === count($explode) && $page !== null) {
                $breadcrumbs->addItem($page->getTitle(), $crumblink);
            } else {
                $breadcrumbs->addItem(ucfirst($p), $crumblink);
            }
        }
    }

    public function showArticleAction(Request $request, $year, $month, $day, $slug)
    {
        if (strlen($month) < 2 || strlen($day) < 2) {
            return $this->internalRedirect($year, $month, $day, $slug);
        }

        $page = $this->getHistoryManager()->findByDayMonthYearSlug($day, $month, $year, $slug);
        $dayInfo = $this->createDayInfo($year, $month, $day);

        $this->generateBreadCrumbs($request, $page);

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
