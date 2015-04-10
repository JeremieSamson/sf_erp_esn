<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 10/04/15
 * Time: 15:52
 */

// src/ESN/AdministrationBundle/Entity/CardRepository.php
namespace ESN\AdministrationBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CardRepository extends EntityRepository{

    function getNumberOfCards(){
        $queryCard = $this->getEntityManager()->createQuery(
            'SELECT c
            FROM ESNAdministrationBundle:Card c
            ORDER BY c.date DESC
            '
        )->setMaxResults(1);


        $nbCardQuery = $queryCard->getOneOrNullresult();
        if ($nbCardQuery == NULL) {
            $nbCard = 0;
        } else {
            $nbCard = $nbCardQuery->getNumber();
        }

        return $nbCard;
    }
}
