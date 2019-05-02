<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class TaskRepository extends EntityRepository
{
    /**
     * @param bool $isDone
     * @return mixed
     */
    public function getAllTaskByDone(bool $isDone)
    {
        return $this->createQueryBuilder('t')
            ->where('t.isDone = :is_done')
            ->setParameter('is_done', $isDone)
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}
