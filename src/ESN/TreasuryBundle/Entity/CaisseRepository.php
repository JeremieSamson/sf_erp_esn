<?php
/**
 * Created by PhpStorm.
 * User: Jérémie Samson | jeremie@ylly.fr
 * Date: 26/04/15
 * Time: 18:43
 */

namespace ESN\TreasuryBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CaisseRepository extends EntityRepository {

    function getLastCaisse(){
        // CAISSE
        $query = $this->getEntityManager()->createQuery(
            'SELECT c
                    FROM ESNTreasuryBundle:Caisse c
                    ORDER BY c.date DESC
                    '
        )->setMaxResults(1);

        $montantQuery = $query->getOneOrNullresult();

        if ($montantQuery == NULL) {
            $montant = 0;
        } else {
            $montant = $montantQuery->getMontant();
        }

        return $montant;
    }
}