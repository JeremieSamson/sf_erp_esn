<?php
/**
 * Created by PhpStorm.
 * User: Jérémie Samson | jeremie@ylly.fr
 * Date: 26/04/15
 * Time: 18:43
 */

namespace ESN\TreasuryBundle\Entity;

use Doctrine\ORM\EntityRepository;

class OperationRepository extends EntityRepository {

    function getOperationsOrdered(){
        $queryBuilder = $this->createQueryBuilder('o')
            ->orderBy('o.date', 'DESC')
        ;

        return $queryBuilder->getQuery()->getResult();
    }
}