<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 16/04/15
 * Time: 22:12
 */

namespace ESN\PermanenceBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ESN\MembersBundle\Entity\Erasmus;
use ESN\MembersBundle\Entity\Member;
use ESN\AdministrationBundle\Entity\University;
use ESN\AdministrationBundle\Entity\Country;
use ESN\PermanenceBundle\Entity\ParticipateTrip;


class LoadParticipateTripData extends AbstractFixture implements OrderedFixtureInterface
{
    private $manager;

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager){
       /* $this->manager = $manager;

        $members = $manager->getRepository('ESNMembersBundle:Member')->findAll();
        $trips   = $manager->getRepository('ESNAdministrationBundle:Trip')->findAll();

        foreach($members as $member){
            $participateTrip = new ParticipateTrip();
            $participateTrip->setDateInscription(new \DateTime());
            $participateTrip->setMembers($manager->getRepository('ESNMembersBundle:Member')->find($members[rand(0,count($members)-1)]));
            $participateTrip->setTrips($manager->getRepository('ESNAdministrationBundle:Trip')->find($trips[rand(0,count($trips)-1)]));
            $this->manager->persist($participateTrip);
        }
        $this->manager->flush();*/
    }

    public function getOrder()
    {
        return 11;
    }
}
