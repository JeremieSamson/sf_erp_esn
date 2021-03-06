<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 22:53
 */

namespace ESN\PermanenceBundle\Form\Handler;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use ESN\MembersBundle\Entity\Erasmus;
use ESN\PermanenceBundle\Entity\ParticipateTrip;
use ESN\TreasuryBundle\Entity\Caisse;
use ESN\TreasuryBundle\Entity\Operation;
use Symfony\Component\Form\Form;
use ESN\MembersBundle\Entity\Member;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class EnrollUserToTripHandler
{
    protected $em;
    protected $request;
    protected $form;

    /**
     * Initialize the handler with the form and the request.
     * @param
     * @param Form    $form
     * @param Request $request
     * @param $mailer
     */
    public function __construct(EntityManager $em, Form $form, Request $request)
    {
        $this->em = $em;
        $this->form = $form;
        $this->request = $request;
    }

    public function process()
    {
        if ('POST' == $this->request->getMethod()) {

            if ($this->form->isValid()) {
                /** @var ParticipateTrip $participateTrip */
                $participateTrip = $this->form->getData();

                $users = new ArrayCollection();
                $participateTrips = $this->em->getRepository('ESNPermanenceBundle:ParticipateTrip')->findByTrip($participateTrip->getTrip());
                /** @var ParticipateTrip $pt */
                foreach($participateTrips as $pt){
                    if (!$users->contains($pt->getUser()))
                        $users->add($pt->getUser());
                }



                if (!$users->contains($participateTrip->getUser())){
                    $this->onSuccess($participateTrip);

                    return true;
                }else{
                    // Erreur to return
                }
            }
        }

        return false;
    }

    protected function onSuccess(ParticipateTrip $participateTrip){
        $participateTrip->setDateInscription(new \DateTime());

        $operation = new Operation();
        $operation->setDate(new \DateTime());
        $operation->setDescription("New payment for the trip : " . $participateTrip->getTrip()->getName());
        $operation->setLibelle("Payment for a trip");
        $operation->setMontant($participateTrip->getTrip()->getPrice());

        $montant = $this->em->getRepository('ESNTreasuryBundle:Caisse')->getLastCaisse();

        $caisse = new Caisse();
        $caisse->setMontant($montant + $operation->getMontant());

        $this->em->persist($caisse);
        $this->em->persist($operation);
        $this->em->persist($participateTrip);

        $this->em->flush();
    }
}