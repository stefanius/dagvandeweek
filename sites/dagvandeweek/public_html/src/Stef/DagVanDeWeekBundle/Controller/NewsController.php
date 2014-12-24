<?php

namespace Stef\BierInDeKlokBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManager;

class NewsController extends BaseController
{
    /**
     * Show a news entry
     */
    public function showAction($slug)
    {
        $news = $this->getNewsManager()->read($slug);

        if (!$news) {
            throw $this->createNotFoundException('Unable to find News post.');
        }

        return $this->render('StefBierInDeKlokBundle:News:show.html.twig', array(
            'page'      => $news,
        ));
    }

    /**
     * Show the news archive
     */
    public function showMainNewsPageAction()
    {
        /**
         * @var EntityManager
         */
        $em = $this->getDoctrine()->getManager();

        /**
         * @var QueryBuilder
         */
        $qb = $em->getRepository('StefSimpleCmsBundle:News')->createQueryBuilder('n');

        $qb->select('n')
            ->setMaxResults(20)
            ->orderBy('n.id', 'DESC');


        $newsitems = $qb->getQuery()->getResult();

        $page['title'] = "Nieuws overzicht";

        return $this->render('StefBierInDeKlokBundle:News:index.html.twig', array(
            'newsitems' => $newsitems,
            'page' => $page,
        ));
    }
}