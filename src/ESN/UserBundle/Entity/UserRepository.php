<?php

namespace ESN\UserBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository{

    public function countESNers()
    {
        return $this->countUser();
    }

    public function countInternationalStudents()
    {
        return $this->countUser(0);
    }

    private function countUser($isEsner = 1)
    {
        $qb = $this->createQueryBuilder('u');

        $qb
            ->select('COUNT(u)')
            ->where($qb->expr()->eq('u.esner', ':isEsner'))
            ->setParameter('isEsner', $isEsner)
        ;

        return $qb->getQuery()->getSingleScalarResult();
    }

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
