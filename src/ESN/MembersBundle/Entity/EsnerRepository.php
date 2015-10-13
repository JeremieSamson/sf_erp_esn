<?php

namespace ESN\MembersBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EsnerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EsnerRepository extends EntityRepository
{
    public function findWithSearch($where){
        $query = $this->createQueryBuilder('e')
            ->leftJoin("e.member", "m");

        if ($where['pole'] != null){
            $query = $query
                ->where("e.pole = :pole")
                ->setParameter('pole', $where['pole']);
        }
        if ($where['university'] != null){
            $query = $query
                ->andWhere("m.university = :university")
                ->setParameter('university', $where['university']);
        }
        if ($where['country'] != null){
            $query = $query
                ->andWhere("m.nationality= :country")
                ->setParameter('country', $where['country']);
        }
        if ($where['active'] != null){
            $query = $query
                ->andWhere("e.active = :active")
                ->setParameter('active', $where['active']);
        }

        $query = $query
            ->orderBy("m.name", "ASC")
            ->getQuery();

        $result = $query->getResult();
        return $result;
    }

    public function findByOrdered(){
        $query = $this->createQueryBuilder('e')
                      ->leftJoin("e.member", "m")
                      ->orderBy("m.name", "ASC")
                      ->getQuery()
                      ;

        return $query->getResult();
    }
}
