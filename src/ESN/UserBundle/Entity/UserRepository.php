<?php

namespace ESN\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository{
    public function findRecruiters(){
        $qb = $this->createQueryBuilder('u');

        $qb
            ->where('u.galaxy_roles LIKE :recruiter')
            ->setParameter('recruiter',"%Local.recruiter%")
            ->andWhere('u.active = true')
            ->addOrderBy('u.firstname', 'ASC')
            ->addOrderBy('u.lastname', 'ASC')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public function findUserByEmail($email){
        $qb = $this->createQueryBuilder('u');

        $qb
            ->where('u.email = :email')
            ->setParameter('email', $email)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
