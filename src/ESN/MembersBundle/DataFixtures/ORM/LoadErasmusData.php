<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 17/04/15
 * Time: 11:36
 */

namespace ESN\MembersBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ESN\MembersBundle\Entity\Erasmus;
use ESN\MembersBundle\Entity\Esner;
use ESN\MembersBundle\Entity\Member;
use ESN\AdministrationBundle\Entity\University;
use ESN\AdministrationBundle\Entity\Country;

class LoadErasmusData extends AbstractFixture implements OrderedFixtureInterface
{
    private $manager;
    private $types = array("rue", "boulevard", "avenue");
    private $addresses = array("gosselin", "valenciennes", "béthune");
    private $cities = array("Lille", "Valenciennes", "Compiègne", "Clermont", "Lyon");
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager){
        /*$this->manager = $manager;

        $nationalities = $manager->getRepository('ESNAdministrationBundle:Country')->findOneByName("France");
        $erasmus_members = $nationalities->getMembers();
        foreach($erasmus_members as $member){
            $erasmus = new Erasmus();
            $erasmus->setMember($member);
            $erasmus->setLeavingDate(new \DateTime());
            $erasmus->setArrivalDate(new \DateTime());
            $erasmus->setEsncard($this->getRandomEsnCard());

            $manager->persist($erasmus);
        }*/

        $manager->flush();
    }

    private function getRandomEsnCard(){
        $char = "0123456789abcdefghijklmnopqrstuvwxyz";
        $card = "";
        for ($i=0 ; $i<10 ; $i++){
            $card.= $char[rand(0, strlen($char)-1)];
        }
        return $card;
    }

    public function getOrder()
    {
        return 8;
    }
}
