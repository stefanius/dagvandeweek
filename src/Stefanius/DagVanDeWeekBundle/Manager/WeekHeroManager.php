<?php

namespace Stefanius\DagVanDeWeekBundle\Manager;

use Stefanius\SimpleCmsBundle\Manager\AbstractObjectManager;
use Symfony\Component\HttpFoundation\ParameterBag;

class WeekHeroManager extends AbstractObjectManager
{
    protected $repoName = 'StefaniusDagVanDeWeekBundle:WeekHero';

    /**
     * {@inheritdoc}
     */
    public function create(ParameterBag $data)
    {
        /*
        $news = new News();

        $news->setTitle($data->get('title'));
        $news->setBody($data->get('body'));
        $news->setPicture($data->get('picture'));
        $news->setSlug($this->slugifier->manipulate($news->getTitle() . '-' . rand(100 , 999)));

        return $news; */
    }

    /**
     * @param $year
     * @param $week
     *
     * @return mixed
     */
    public function findOneByYearAnWeek($year, $week)
    {
        $qb = $this->om->getRepository($this->repoName)->createQueryBuilder('e');

        $qb->select('e');
        $qb->where('e.year = :year');
        $qb->andWhere('e.week = :week');
        $qb->setParameter('year', $year);
        $qb->setParameter('week', $week);

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * @param $year
     * 
     * @return mixed
     */
    public function findByYear($year)
    {
        return $this->om->getRepository($this->repoName)->findByYear($year);
    }
}
