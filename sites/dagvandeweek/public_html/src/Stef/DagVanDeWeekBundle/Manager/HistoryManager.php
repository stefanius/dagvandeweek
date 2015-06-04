<?php

namespace Stef\DagVanDeWeekBundle\Manager;

use Doctrine\Entity;
use Stef\SimpleCmsBundle\Manager\AbstractObjectManager;
use Symfony\Component\HttpFoundation\ParameterBag;

class HistoryManager extends AbstractObjectManager
{
    protected $repoName = 'StefDagVanDeWeekBundle:History';

    /**
     * @param ParameterBag $data
     *
     * @return Entity
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
     * @param $key
     *
     * @return mixed
     */
    public function read($key)
    {
        $entity = parent::read($key);

        if ($entity === null) {
            $entity = $this->om->getRepository($this->repoName)->findOneBySlug($key);
        }

        return $entity;
    }

    public function findByYear($year)
    {
        return $this->om->getRepository($this->repoName)->findByYear($year);
    }

    public function findByMonth($month)
    {
        return $this->om->getRepository($this->repoName)->findByMonth($month);
    }

    public function findByMonthYear($month, $year)
    {
        $qb = $this->om->getRepository($this->repoName)->createQueryBuilder('e');

        $qb->select('e');
        $qb->where('e.year = :year AND e.month = :month');
        $qb->setParameter('month', $month);
        $qb->setParameter('year', $year);

        return $qb->getQuery()->getResult();
    }

    public function findByDayMonthYear($day, $month, $year)
    {
        $qb = $this->om->getRepository($this->repoName)->createQueryBuilder('e');

        $qb->select('e');
        $qb->where('e.year = :year AND e.month = :month AND e.day = :day');
        $qb->setParameter('day', $day);
        $qb->setParameter('month', $month);
        $qb->setParameter('year', $year);

        return $qb->getQuery()->getResult();
    }

    public function findByDayMonth($day, $month)
    {
        $qb = $this->om->getRepository($this->repoName)->createQueryBuilder('e');

        $qb->select('e');
        $qb->where('e.month = :month AND e.day = :day');
        $qb->setParameter('day', $day);
        $qb->setParameter('month', $month);

        return $qb->getQuery()->getResult();
    }

    public function findByDayMonthYearSlug($day, $month, $year, $slug)
    {
        $qb = $this->om->getRepository($this->repoName)->createQueryBuilder('e');

        $qb->select('e');
        $qb->where('e.year = :year');
        $qb->andWhere('e.month = :month');
        $qb->andWhere('e.day = :day');
        $qb->andWhere('e.slug = :slug');
        $qb->setParameter('day', $day);
        $qb->setParameter('month', $month);
        $qb->setParameter('year', $year);
        $qb->setParameter('slug', $slug);

        return $qb->getQuery()->getSingleResult();
    }

    public function getActiveYears()
    {
        $qb = $this->om->getRepository($this->repoName)->createQueryBuilder('e');

        $qb->select('e.year')
            ->distinct();

        return $qb->getQuery()->getResult();
    }
}
