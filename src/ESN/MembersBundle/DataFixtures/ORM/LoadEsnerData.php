<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 17/04/15
 * Time: 11:18
 */
namespace ESN\MembersBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ESN\AdministrationBundle\Entity\University;
use ESN\AdministrationBundle\Entity\Country;

class LoadEsnerData extends AbstractFixture implements OrderedFixtureInterface
{
    private $types = array("rue", "boulevard", "avenue");
    private $addresses = array("gosselin", "valenciennes", "béthune");
    private $cities = array("Lille", "Valenciennes", "Compiègne", "Clermont", "Lyon");
    private $manager;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager){
       /* $this->manager = $manager;
        $esn_members = $manager->getRepository('ESNMembersBundle:Member')->findAll();
        $poles = $manager->getRepository('ESNAdministrationBundle:Pole')->findAll();
        $maxPoleId = $this->getMaxPoleId();

        foreach($esn_members as $member){
            $esner = new Esner();
            $esner->setMember($member);
            $esner->setAddress($this->getRandomAddress());
            $esner->setCity($this->getRandomCity());
            $esner->setZipcode($this->getRandomZipCode());
            $esner->setPole($manager->getRepository('ESNAdministrationBundle:Pole')->findOneBy(array("id" => rand($maxPoleId - count($poles) + 1,$maxPoleId))));
            $esner->setErasmusProgramme($this->getRandomCountry());
            $esner->setHasCare(rand(0,1));
            $manager->persist($esner);
        }

        $manager->flush();
  */
    }

    private function getMaxPoleId(){
        return $this->manager->createQueryBuilder()
            ->select('MAX(p.id)')
            ->from('ESNAdministrationBundle:Pole', 'p')
            ->getQuery()
            ->getSingleScalarResult();
    }
    private function getRandomAddress(){
        return rand(1,200) . " " . $this->getRandomType() . " " . $this->getRandomAddressName();
    }

    private function getRandomAddressName(){
        return $this->addresses[rand(0, count($this->addresses)-1)];
    }

    private function getRandomType(){
        return $this->types[rand(0, count($this->types)-1)];
    }

    private function getRandomZipCode(){
        return intval("59" . rand(0,9) . rand(0,9) .rand(0,9));
    }

    private function getRandomCity(){
        return $this->cities[rand(0, count($this->cities)-1)];
    }

    private function getRandomCountry(){
        return $this->manager->getRepository('ESNAdministrationBundle:Country')->find(rand(1,192));
    }

    public function getOrder()
    {
        return 7;
    }
}
