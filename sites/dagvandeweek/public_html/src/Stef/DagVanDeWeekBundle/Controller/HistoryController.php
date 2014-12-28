<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Stef\DagVanDeWeekBundle\Entity\HistoryYear;

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

    public function showByYearAction($year)
    {
        $page = $this->buildHistoryPage($year);
        $items = $this->getHistoryManager()->findByYear($year);

        return $this->render('StefDagVanDeWeekBundle:History:year.html.twig', [
            'page' => $page,
            'items' => $items
        ]);
    }

    public function showArticleAction($year, $month, $day, $slug)
    {
        $page = $this->getHistoryManager()->findByDayMonthYearSlug($day, $month, $year, $slug);

        return $this->render('StefDagVanDeWeekBundle:History:article.html.twig', [
            'page' => $page
        ]);
    }
}
