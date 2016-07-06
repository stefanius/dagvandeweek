<?php

namespace Stefanius\DagVanDeWeekBundle\Controller;

use Stefanius\SimpleCmsBundle\Entity\Page;

class WeekHeroController extends BaseController
{
    /**
     * @param $year
     * @param $week
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($year, $week)
    {
        $page = $this->getWeekHeroManager()->findOneByYearAnWeek($year, $week);

        return $this->render('StefaniusDagVanDeWeekBundle:WeekHero:show.html.twig', [
            'page' => $page,
        ]);
    }

    /**
     * @param $year
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showByYearAction($year)
    {
        $heroes = $this->getWeekHeroManager()->findByYear($year);
        $page   = new Page();
        $page->setTitle('Topper van de Week ' . $year);

        if (count($heroes) == 0 || $year < 2012 || $year > 2015) {
            $page->setRobotsIndex(false);
        }

        return $this->render('StefaniusDagVanDeWeekBundle:WeekHero:index.html.twig', [
            'page'   => $page,
            'year'   => $year,
            'heroes' => $heroes,
        ]);
    }
}
