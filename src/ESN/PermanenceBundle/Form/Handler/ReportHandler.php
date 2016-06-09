<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 22:53
 */

namespace ESN\PermanenceBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use ESN\AdministrationBundle\Entity\Card;
use ESN\MembersBundle\Entity\Erasmus;
use ESN\PermanenceBundle\Entity\ParticipateTrip;
use ESN\PermanenceBundle\Entity\PermanenceReport;
use ESN\TreasuryBundle\Entity\Caisse;
use ESN\TreasuryBundle\Entity\Operation;
use ESN\UserBundle\Entity\User;
use Symfony\Component\Form\Form;
use ESN\MembersBundle\Entity\Member;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class ReportHandler
{
    protected $em;
    protected $request;
    protected $form;
    protected $user;

    /**
     * @param EntityManager $em
     * @param Form $form
     * @param Request $request
     * @param User $user
     */
    public function __construct(EntityManager $em, Form $form, Request $request, User $user)
    {
        $this->em = $em;
        $this->form = $form;
        $this->request = $request;
        $this->user = $user;
    }

    public function process()
    {
        if ('POST' == $this->request->getMethod()) {

            if ($this->form->isValid()) {

                /** @var PermanenceReport $report */
                $report = $this->form->getData();

                if ($report){
                    $this->onSuccess($report);
                }
            }

            return true;
        }

        return false;
    }

    protected function onSuccess(PermanenceReport $report){
        //Remove numbers of card
        $sellcard = $report->getSellCard();
        $nbCard = $this->em->getRepository('ESNAdministrationBundle:Card')->getNumberOfCards();
        $availableCard = $nbCard - $sellcard;

        $report->setAmountSell($report->getSellCard()*5);
        $report->setOwner($this->user);

        $Card = new Card();
        $Card->setNumber($availableCard);
        $this->em->persist($Card);

        if ($report->getAmountSell() > 0){
            $operation = new Operation();
            $operation->setMontant($report->getAmountSell());
            $operation->setDate(new \DateTime());
            $operation->setLibelle("Vente carte ESN pendant la perm");
            $operation->setDescription("Vente de " . $report->getSellCard() . " cartes ESN");
            $this->em->persist($operation);
        }

        // CAISSE
        $montant = $this->em->getRepository('ESNTreasuryBundle:Caisse')->getLastCaisse();

        $caisse = new Caisse();
        $caisse->setMontant($montant + $report->getAmountSell());
        $this->em->persist($caisse);

        if (!$report->getId()){
            $this->em->persist($report);
        }

        $this->em->flush();
    }
}