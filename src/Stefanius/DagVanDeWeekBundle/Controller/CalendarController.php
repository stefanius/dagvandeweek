<?php

namespace Stefanius\DagVanDeWeekBundle\Controller;

use Stefanius\DagVanDeWeekBundle\BreadcrumbGenerator\CalendarTitleBuilder;
use Stefanius\DagVanDeWeekBundle\BreadcrumbGenerator\TitleBuilderInterface;
use Stefanius\DagVanDeWeekBundle\Entity\CalendarYear;
use Stefanius\SimpleCmsBundle\Entity\Page;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalendarController extends BaseController
{
    /**
     * @param $year
     *
     * @return Page
     */
    protected function buildCalendarPage($year)
    {
        $page = $this->getCalendarYearManager()->read($year);

        if ($page === null) {
            $page = new CalendarYear();
            $page->setTitle('Kalender ' . $year);
            $page->setYear($year);
            $page->setSlug($year);

            if ($year < date('Y')) {
                $p1 = '<p>Het jaar ' . $year . ' was een jaar vol gebeurtenissen. Op alle lagen in de bevolking heeft ' . $year . ' zijn sporen nagelaten in de geschiedenisboeken.</p>';
                $p2 = '<h2>Terug in de tijd</h2><p>Door een blik te werpen op de kalender van ' . $year . ' maak je een reis terug in de tijd. Je kijkt nu naar een kalender die ' . (date('Y') - $year) . ' jaar oud is. Naast wat specifieke info over dit jaar, vertellen wij ook graag meer over de tijdsgeest en periode. Om meer te weten te komen over andere jaren die in de buurt liggen kan je met het lijstje aan de rechterkant snel door de geschiedenis heen bladeren!</p>';
            } else {
                $p1 = '<p>Niemand kan in de toekomst kijken. Ook wij niet. Al zouden wij dat ook graag willen weten. Want hoe mooi zou het zijn om te weten of je in ' . $year . ' nog steeds getrouwd bent? Of heb je tegen die tijd al een mooi geldbedrag gespaard of gewonnen. Allemaal vragen over jouw toekomst. Wij weten het niet. Je zal nog ' . ($year - date('Y')) . ' jaren moeten wachten om erachter te komen hoe jouw leven en die van de maatschappij in elkaar steekt.</p>';
                $p2 = '<h2>Keurig overzicht</h2><p>Toch willen wij je een overzicht geven over de maanden, weken en dagen van ' . $year . '. Zodat je alvast je vakantie zou kunnen plannen of misschien blijk je wel op een bepaalde dag in dat jaar jarig te zijn. Kijk daarom in de onderstaande kalender van ' . $year . ' voor een kleine blik in de toekomst!</p>';
            }

            $page->setBody($p1 . $p2);
        }

        if ($page->getTitle() == $year && strlen($page->getTitle()) < 5) {
            $page->setTitle('Kalender ' . $page->getYear());
        }

        if ($page->getDescription() === null || strlen($page->getDescription()) < 5) {
            $page->setDescription($page->getYear() . ' was een TOP jaar! Kijk hier voor de kalender ' . $page->getYear() . '. Op Dag Van De Week kunt u de historie ' . $page->getYear() . ' bekijken! Bekijk hier de Kalender ' . $page->getYear());
        }

        return $page;
    }

    /**
     * @param Request $request
     * @param $year
     *
     * @return Response
     */
    public function showAction(Request $request, $year)
    {
        if (!is_numeric($year)) {
            $this->redirect('/kalender');
        }

        if ((int) $year < 30) {
            $this->redirect('/kalender', 301);
        }

        $page = $this->buildCalendarPage($year);

        return $this->render('StefaniusDagVanDeWeekBundle:Calendar:year.html.twig', [
            'page' => $page,
        ], null, $request);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function showIndexAction(Request $request)
    {
        $years = $this->getHistoryManager()->getActiveYears();
        $page  = new Page();

        $page->setTitle('Jaarkalenders');
        $page->setDescription(
            'Elk jaar bevat maanden, dagen en weken. Elk dag is een klein stukje van een jaar! Wij bieden hier uitgebreide kalenders aan van een groot aantal jaren!'
        );

        return $this->render('StefaniusDagVanDeWeekBundle:Calendar:index.html.twig', [
            'years' => $years,
            'page'  => $page,
        ], null, $request);
    }

    /**
     * {@inheritdoc}
     */
    public function render(
        $view,
        array $parameters = array(),
        Response $response = null,
        Request $request = null,
        TitleBuilderInterface $breadcrumbTitleBuilder = null
    ) {
        if ($breadcrumbTitleBuilder === null) {
            $breadcrumbTitleBuilder = new CalendarTitleBuilder();
        }

        return parent::render($view, $parameters, $response, $request, $breadcrumbTitleBuilder);
    }
}
