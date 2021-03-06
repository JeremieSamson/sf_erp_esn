<?php

namespace ESN\AdministrationBundle\Entity;

/**
 * ActivityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActivityRepository extends \Doctrine\ORM\EntityRepository
{
    public function getOrderedActivities($order) {
        $queryBuilder = $this->createQueryBuilder('a');
        $queryBuilder->orderBy('a.createdAt', $order);

        return $queryBuilder->getQuery()->getResult();
    }
}
