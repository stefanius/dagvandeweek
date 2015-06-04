<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Stef\SimpleCmsBundle\Entity\Page;

class WeekHeroController extends BaseController
{
    public function showAction($year, $week)
    {
        $page = $this->getWeekHeroManager()->findOneByYearAnWeek($year, $week);

        return $this->render('StefDagVanDeWeekBundle:WeekHero:show.html.twig', [
            'page' => $page,
        ]);
    }

    public function showByYearAction($year)
    {
        $heroes = $this->getWeekHeroManager()->findByYear($year);
        $page = new Page();
        $page->setTitle('Topper van de Week '.$year);

        if (count($heroes) == 0 || $year < 2012 || $year > 2015) {
            $page->setRobotsIndex(false);
        }

        return $this->render('StefDagVanDeWeekBundle:WeekHero:index.html.twig', [
            'page' => $page,
            'year' => $year,
            'heroes' => $heroes,
        ]);
    }
}
