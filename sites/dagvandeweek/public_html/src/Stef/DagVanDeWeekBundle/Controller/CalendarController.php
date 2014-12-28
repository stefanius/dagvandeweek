<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Stef\DagVanDeWeekBundle\Entity\CalendarYear;

class CalendarController extends BaseController
{
    protected function buildCalendarPage($year)
    {
        $page = $this->getCalendarYearManager()->read($year);

        if ($page === null) {
            $page = new CalendarYear();
            $page->setTitle($year);
            $page->setYear($year);
            $page->setSlug($year);

            if ($year < date("Y")) {
                $p1 = '<p>Het jaar ' . $year . ' was een jaar vol gebeurtenissen. Op alle lagen in de bevolking heeft ' . $year . ' zijn sporen nagelaten in de geschiedenisboeken.</p>';
                $p2 = '<h2>Terug in de tijd</h2><p>Door een blik te werpen op de kalender van ' . $year . ' maak je een reis terug in de tijd. Je kijkt nu naar een kalender die ' .  (date("Y") - $year) . ' jaar oud is. Naast wat specifieke info over dit jaar, vertellen wij ook graag meer over de tijdsgeest en periode. Om meer te weten te komen over andere jaren die in de buurt liggen kan je met het lijstje aan de rechterkant snel door de geschiedenis heen bladeren!</p>';
                $page->setBody($p1 . $p2);
            } else {
                $p1 = '<p>Niemand kan in de toekomst kijken. Ook wij niet. Al zouden wij dat ook graag willen weten. Want hoe mooi zou het zijn om te weten of je in ' . $year . ' nog steeds getrouwd bent? Of heb je tegen die tijd al een mooi geldbedrag gespaard of gewonnen. Allemaal vragen over jouw toekomst. Wij weten het niet. Je zal nog ' . ($year - date("Y")) . ' jaren moeten wachten om erachter te komen hoe jouw leven en die van de maatschappij in elkaar steekt.</p>';
                $p2 = '<h2>Keurig overzicht</h2><p>Toch willen wij je een overzicht geven over de maanden, weken en dagen van ' . $year . '. Zodat je alvast je vakantie zou kunnen plannen of misschien blijk je wel op een bepaalde dag in dat jaar jarig te zijn. Kijk daarom in de onderstaande kalender van ' . $year . ' voor een kleine blik in de toekomst!</p>';
                $page->setBody($p1 . $p2);
            }
        }

        return $page;
    }

    public function showAction($year)
    {
        $page = $this->buildCalendarPage($year);

        return $this->render('StefDagVanDeWeekBundle:Calendar:year.html.twig', [
            'page' => $page
        ]);
    }
}
