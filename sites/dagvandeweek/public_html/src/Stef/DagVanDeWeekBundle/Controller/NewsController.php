<?php

namespace Stef\DagVanDeWeekBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Stef\DagVanDeWeekBundle\BreadcrumbGenerator\DefaultTitleBuilder;
use Stef\DagVanDeWeekBundle\BreadcrumbGenerator\TitleBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends BaseController
{
    /**
     * Show a news entry.
     */
    public function showAction(Request $request, $slug)
    {
        $news = $this->getNewsManager()->read($slug);

        if (!$news) {
            throw $this->createNotFoundException('Unable to find News post.');
        }

        return $this->render('StefDagVanDeWeekBundle:News:show.html.twig', array(
            'page' => $news,
        ), null, $request);
    }

    /**
     * Show the news archive.
     */
    public function showMainNewsPageAction(Request $request)
    {
        /*
         * @var EntityManager
         */
        $em = $this->getDoctrine()->getManager();

        /*
         * @var QueryBuilder
         */
        $qb = $em->getRepository('StefSimpleCmsBundle:News')->createQueryBuilder('n');

        $qb->select('n')
            ->setMaxResults(20)
            ->orderBy('n.id', 'DESC');

        $newsitems = $qb->getQuery()->getResult();

        $page['title'] = 'Nieuws overzicht';

        return $this->render('StefDagVanDeWeekBundle:News:index.html.twig', array(
            'newsitems' => $newsitems,
            'page' => $page,
        ), null, $request);
    }

    /**
     * {@inheritdoc}
     */
    public function render($view, array $parameters = array(), Response $response = null, Request $request = null, TitleBuilderInterface $breadcrumbTitleBuilder = null)
    {
        if ($breadcrumbTitleBuilder === null) {
            $breadcrumbTitleBuilder = new DefaultTitleBuilder();
        }

        return parent::render($view, $parameters, $response, $request, $breadcrumbTitleBuilder);
    }
}
