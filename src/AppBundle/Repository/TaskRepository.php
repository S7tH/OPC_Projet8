<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;


class TaskRepository extends EntityRepository
{
    public function findAllTasks()
    {
        return $this
        ->createQueryBuilder('a')
        ->getQuery()
        ->useResultCache(true, 1, 'id')
        ->getResult()
      ;
    }

    public function findByIsTaskDone(Bool $state)
    {
        return $this
        ->createQueryBuilder('a')
        ->where('a.isDone = :state')
            ->setParameter('state', $state)
        ->getQuery()
        ->useResultCache(true, 1, 'id')
        ->getResult()
      ;
    }
}