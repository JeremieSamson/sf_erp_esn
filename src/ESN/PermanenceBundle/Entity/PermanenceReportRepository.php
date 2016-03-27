<?php

namespace ESN\PermanenceBundle\Entity;

class PermanenceReportRepository extends \Doctrine\ORM\EntityRepository
{
    public function getLast() {
        $queryBuilder = $this->createQueryBuilder('p');
        $queryBuilder
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(1)
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}
