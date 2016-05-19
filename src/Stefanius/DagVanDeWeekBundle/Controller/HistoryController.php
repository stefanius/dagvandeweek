<?php

namespace Stefanius\DagVanDeWeekBundle\Controller;

use Stefanius\DagVanDeWeekBundle\BreadcrumbGenerator\HistoryTitleBuilder;
use Stefanius\DagVanDeWeekBundle\BreadcrumbGenerator\TitleBuilderInterface;
use Stefanius\DagVanDeWeekBundle\Entity\History;
use Stefanius\DagVanDeWeekBundle\CalendarTranslations\Dutch;
use Stefanius\DagVanDeWeekBundle\Entity\HistoryYear;
use Stefanius\SimpleCmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\Response;
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

            if ($year < date('Y')) {
                $p1 = '<p>Het jaar ' . $year . ' ligt alweer ' . (date('Y') - $year) . ' jaar achter ons. Er is in dat jaar veel gebeurt en wij willen dat graag met jou delen! Elke dag van de week is beinvloed door de dagen van voorgaande weken. OF iets nu gisteren of vorgie week is gebeurt. Vorig jaar of 400 jaar geleden. Wij zoeken het uit. En delen het met jou! Elke dag opnieuw. Wat vandaag in het nieuws is, is morgen geschiedenis!</p>';

                $page->setBody($p1);
            } else {
                $p1 = "<p>Deze pagina's gaan over de geschiedenis. Ons verleden. Het jaar " . $year . ' laat nog ' . ($year - date('Y')) . ' jaar op zich wachten. Het is dus zeer aannemelijk dat wij nog niet beschikken over enorme hoeveelheden gebeurtenissen uit het jaar ' . $year . '. Wellicht ben je wel geintreseerd in de ' . '<a href="http://dagvandeweek.nl/kalender/' . $year . '">kalender</a> uit de (verre) toekomst?</p>';

                $page->setBody($p1);
            }
        }

        if ($page->getTitle() == $year && strlen($page->getTitle()) < 5) {
            $page->setTitle('Historie ' . $page->getYear());
        }

        return $page;
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

        if ($month == null || $month === '00' || $month === '0') {
            return $this->redirect('/historie/' . $year);
        }

        if ($day == null || $day === '00' || $day === '0') {
            return $this->redirect('/historie/' . $year . '/' . sprintf('%1$02d', $month));
        }

        if ($slug == null) {
            return $this->redirect('/historie/' . $year . '/' . sprintf('%1$02d', $month) . '/' . sprintf('%1$02d', $day));
        }

        return $this->redirect('/historie/' . $year . '/' . sprintf('%1$02d', $month) . '/' . sprintf('%1$02d', $day) . '/' . $slug);
    }

    /**
     * @param Request $request
     * @param $year
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showByYearAction(Request $request, $year)
    {
        $page  = $this->buildHistoryPage($year);
        $items = $this->getHistoryManager()->findByYear($year);

        if (count($items) == 0) {
            $page->setRobotsIndex(false);
        }

        return $this->render('StefaniusDagVanDeWeekBundle:History:year.html.twig', [
            'page'  => $page,
            'items' => $items,
        ], null, $request);
    }

    /**
     * @param Request $request
     * @param $year
     * @param $month
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showByYearMonthAction(Request $request, $year, $month)
    {
        if (strlen($month) < 2) {
            return $this->internalRedirect($year, $month);
        }

        if ($month === '00') {
            return $this->internalRedirect($year, $month);
        }

        $dayInfo = $this->createDayInfo($year, $month, 1);

        $page  = $this->buildHistoryPage($year);
        $items = $this->getHistoryManager()->findByMonthYear($month, $year);

        $page->setRobotsIndex(false);
        $page->setRobotsFollow(true);

        if (count($items) > 0) {
            $page->setRobotsIndex(true);
        }

        return $this->render('StefaniusDagVanDeWeekBundle:History:month.html.twig', [
            'page'    => $page,
            'items'   => $items,
            'month'   => $month,
            'dayInfo' => $dayInfo,
        ], null, $request);
    }

    /**
     * @param Request $request
     * @param $year
     * @param $month
     * @param $day
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showByYearMonthDayAction(Request $request, $year, $month, $day)
    {
        if (strlen($month) < 2 || strlen($day) < 2) {
            return $this->internalRedirect($year, $month, $day);
        }

        if ($month === '00' && $day === '00') {
            return $this->internalRedirect($year, $month, $day);
        }

        $items   = $this->getHistoryManager()->findByDayMonthYear($day, $month, $year);
        $dayInfo = $this->createDayInfo($year, $month, $day);

        $page = new History();
        $page->setDay($day);
        $page->setMonth($month);
        $page->setYear($year);
        $page->setTitle(ucfirst($dayInfo['dutchWeekdayName']) . ' ' . $day . ' ' . $dayInfo['dutchMonthName'] . ' ' . $year);

        $page->setRobotsIndex(false);
        $page->setRobotsFollow(true);

        if (count($items) > 0) {
            $page->setRobotsIndex(true);
        }

        return $this->render('StefaniusDagVanDeWeekBundle:History:day.html.twig', [
            'page'    => $page,
            'items'   => $items,
            'month'   => $month,
            'dayInfo' => $dayInfo,
        ], null, $request);
    }

    /**
     * @param Request $request
     * @param $year
     * @param $month
     * @param $day
     * @param $slug
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function showArticleAction(Request $request, $year, $month, $day, $slug)
    {
        if (strlen($month) < 2 || strlen($day) < 2) {
            return $this->internalRedirect($year, $month, $day, $slug);
        }

        if ($slug === 'bombardement%20-rotterdam' || $slug === 'bombardement -rotterdam') {
            $slug = 'bombardement-rotterdam';

            return $this->internalRedirect($year, $month, $day, $slug);
        }

        $page    = $this->getHistoryManager()->findByDayMonthYearSlug($day, $month, $year, $slug);
        $dayInfo = $this->createDayInfo($year, $month, $day);

        return $this->render('StefaniusDagVanDeWeekBundle:History:article.html.twig', [
            'page'    => $page,
            'dayInfo' => $dayInfo,
        ], null, $request);
    }

    public function showIndexAction()
    {
        $latestItems = $this->getHistoryManager()->getLatestEntries(10);
        $years       = $this->getHistoryManager()->getActiveYears();
        $page        = new Page();
        $page->setTitle('Historisch Jaaroverzicht');
        $page->setDescription('DagVanDeWeek heeft een uitgebreide database met gegevens. Hier kan je (bijna) alles vinden wat je wilt! Voor je werkstuk, spreekbeurt of gewoon omdat je het WILT weten! Elke dag van de week is er weer een dag bij in de geschiedenis!');

        return $this->render('StefaniusDagVanDeWeekBundle:History:index.html.twig', [
            'latestItems' => $latestItems,
            'years'       => $years,
            'page'        => $page,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function render($view, array $parameters = array(), Response $response = null, Request $request = null, TitleBuilderInterface $breadcrumbTitleBuilder = null)
    {
        if ($breadcrumbTitleBuilder === null) {
            $breadcrumbTitleBuilder = new HistoryTitleBuilder(new Dutch());
        }

        return parent::render($view, $parameters, $response, $request, $breadcrumbTitleBuilder);
    }
}
