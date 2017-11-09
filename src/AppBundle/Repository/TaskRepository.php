<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class TaskRepository extends EntityRepository
{
    public function findByDone($state)
    {
        $queryBuilder = $this->createQueryBuilder('t');


        $queryBuilder->where('t.is_done = :value')
            ->setParameter('value', $state)
        ->orderBy('t.id', 'ASC');
        
        return $queryBuilder
            ->getQuery()
            ->getResult();
    }
}
