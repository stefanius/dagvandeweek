<?php

namespace Stefanius\DagVanDeWeekBundle\Controller;

use Ivory\GoogleMap\Map;
use Stefanius\DagVanDeWeekBundle\BreadcrumbGenerator\Generator;
use Stefanius\DagVanDeWeekBundle\BreadcrumbGenerator\TitleBuilderInterface;
use Stefanius\DagVanDeWeekBundle\CalendarTranslations\Dutch;
use Stefanius\DagVanDeWeekBundle\Manager\CalendarYearManager;
use Stefanius\DagVanDeWeekBundle\Manager\ContactManager;
use Stefanius\DagVanDeWeekBundle\Manager\DayManager;
use Stefanius\DagVanDeWeekBundle\Manager\HistoryManager;
use Stefanius\DagVanDeWeekBundle\Manager\HistoryYearManager;
use Stefanius\DagVanDeWeekBundle\Manager\WeekHeroManager;
use Stefanius\SimpleCmsBundle\Entity\AbstractCmsContent;
use Stefanius\SimpleCmsBundle\KeyValueParser\Parser;
use Stefanius\SimpleCmsBundle\Manager\DictionaryManager;
use Stefanius\SimpleCmsBundle\Manager\NewsManager;
use Stefanius\SimpleCmsBundle\Manager\PageManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use WhiteOctober\BreadcrumbsBundle\Model\Breadcrumbs;

class BaseController extends Controller
{
    protected function getEntityManager()
    {
        return $this->getDoctrine()->getManager();
    }

    protected function getRepository($repository)
    {
        $em = $this->getEntityManager();

        return $em->getRepository($repository);
    }

    /**
     * @return DictionaryManager
     */
    protected function getDictionaryManager()
    {
        return $this->get('stef_simple_cms.dictionary_manager');
    }

    /**
     * @return PageManager
     */
    protected function getPageManager()
    {
        return $this->get('stef_simple_cms.page_manager');
    }

    /**
     * @return ContactManager
     */
    protected function getContactManager()
    {
        return $this->get('stef_simple_cms.contact_manager');
    }

    /**
     * @return NewsManager
     */
    protected function getNewsManager()
    {
        return $this->get('stef_simple_cms.news_manager');
    }

    /**
     * @return CalendarYearManager
     */
    protected function getCalendarYearManager()
    {
        return $this->get('stef_simple_cms.calendar_year_manager');
    }

    /**
     * @return HistoryYearManager
     */
    protected function getHistoryYearManager()
    {
        return $this->get('stef_simple_cms.history_year_manager');
    }

    /**
     * @return HistoryManager
     */
    protected function getHistoryManager()
    {
        return $this->get('stef_simple_cms.history_manager');
    }

    /**
     * @return WeekHeroManager
     */
    protected function getWeekHeroManager()
    {
        return $this->get('stef_simple_cms.weekhero_manager');
    }

    /**
     * @return DayManager
     */
    protected function getDayManager()
    {
        return $this->get('stef_simple_cms.day_manager');
    }

    protected function isAuthenticatedFully()
    {
        return $this->container->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY');
    }

    /**
     * @return Breadcrumbs
     */
    protected function getWhiteOctoberBreadcrumbs()
    {
        return $this->get('white_october_breadcrumbs');
    }

    /**
     * {@inheritdoc}
     */
    public function render($view, array $parameters = array(), Response $response = null, Request $request = null, TitleBuilderInterface $breadcrumbTitleBuilder = null)
    {
        if ($request !== null && $breadcrumbTitleBuilder !== null) {
            $page = null;

            if (array_key_exists('page', $parameters) && $parameters['page'] instanceof AbstractCmsContent) {
                $page = $parameters['page'];
            }

            $this->generateBreadCrumbs($request, $breadcrumbTitleBuilder, $page);
        }

        return parent::render($view, $parameters, $response);
    }

    /**
     * @param Request               $request
     * @param TitleBuilderInterface $breadcrumbTitleBuilder
     * @param AbstractCmsContent    $page
     */
    protected function generateBreadCrumbs(Request $request, TitleBuilderInterface $breadcrumbTitleBuilder, AbstractCmsContent $page = null)
    {
        $generator = new Generator($this->getWhiteOctoberBreadcrumbs());
        $generator->setTitleBuilder($breadcrumbTitleBuilder);
        $crumbs = $generator->generate($request, $page);

        $breadcrumbs = $this->getWhiteOctoberBreadcrumbs();

        foreach ($crumbs as $crumb) {
            $breadcrumbs->addItem($crumb['title'], $crumb['link']);
        }
    }

    /**
     * @param $year
     * @param $month
     * @param $day
     *
     * @return array
     */
    protected function createDayInfo($year, $month, $day)
    {
        $translation = new Dutch();
        $date        = new \DateTime($year . '-' . $month . '-' . $day);

        $weekDayNumber    = $date->format('w');
        $yearDayNumber    = $date->format('z');
        $weekNumber       = $date->format('W');
        $lastDayOfMonth   = $date->format('t');
        $unixSeconds      = $date->format('U');
        $dutchMonthName   = $translation->getMonth($month);
        $dutchWeekdayName = $translation->getDay($weekDayNumber);

        return [
            'weekDayNumber'    => $weekDayNumber,
            'yearDayNumber'    => $yearDayNumber,
            'monthNumber'      => (int) $month,
            'weekNumber'       => $weekNumber,
            'unixSeconds'      => $unixSeconds,
            'dutchMonthName'   => $dutchMonthName,
            'dutchWeekdayName' => $dutchWeekdayName,
            'lastDayOfMonth'   => $lastDayOfMonth,
        ];
    }

    /**
     * @param $monthName
     * @param bool $leadingZero
     *
     * @return int
     */
    protected function getMonthNumber($monthName, $leadingZero = true)
    {
        $translation = new Dutch();

        return $translation->getMonthNumberByName($monthName, $leadingZero);
    }

    /**
     * @return \Stefanius\SpecialDates\DateParser\Parser
     */
    protected function getSpecialDateParser()
    {
        return new \Stefanius\SpecialDates\DateParser\Parser();
    }

    protected function findSpecialDates(\DateTime $date)
    {
        return $this->getSpecialDateParser()->findSpecialDateByDateTime($date);
    }

    protected function findSpecialDatesByMonth($year, $monthNumber)
    {
        return $this->getSpecialDateParser()->findSpecialDateByMonthNumber($year, $monthNumber);
    }
}