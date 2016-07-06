<?php

namespace Stefanius\DagVanDeWeekBundle\Manager;

use Stefanius\DagVanDeWeekBundle\Entity\Day;
use Stefanius\SimpleCmsBundle\Manager\AbstractObjectManager;
use Symfony\Component\HttpFoundation\ParameterBag;

class DayManager extends AbstractObjectManager
{
    protected $repoName = 'StefaniusDagVanDeWeekBundle:Day';

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
