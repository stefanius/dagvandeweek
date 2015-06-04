<?php

namespace Stef\DagVanDeWeekBundle\Manager;

use Doctrine\Entity;
use Doctrine\ORM\QueryBuilder;
use Stef\DagVanDeWeekBundle\Entity\Day;
use Stef\SimpleCmsBundle\Manager\AbstractObjectManager;
use Symfony\Component\HttpFoundation\ParameterBag;

class DayManager extends AbstractObjectManager
{
    protected $repoName = 'StefDagVanDeWeekBundle:Day';

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
     * @param $entity
     */
    public function persist($entity)
    {
        $entity->setSlug($entity->getDay() . '-' . $entity->getMonth());

        parent::persist($entity);
    }

    /**
     * @param $day
     * @param $month
     *
     * @return Day
     */
    public function findByDayAndMonth($day, $month)
    {
        $qb = $this->om->getRepository($this->repoName)->createQueryBuilder('e');

        /*
         * @var QueryBuilder $qb
         */
        $qb->select('e');
        $qb->where('e.day = :day AND e.month = :month');
        $qb->setParameter('month', $month);
        $qb->setParameter('day', $day);

        $result = $qb->getQuery()->getResult();

        if (count($result) === 1) {
            return $result[0];
        }

        return;
    }
}
