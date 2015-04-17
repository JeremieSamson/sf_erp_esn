<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 16/04/15
 * Time: 21:36
 */

namespace ESN\AdministrationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ESN\AdministrationBundle\Entity\Trip;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $trip = new Trip();
        $trip->setName("Trip to Paris");
        $trip->setDate(new \DateTime());
        $trip->setDescription("Super voyage à Paris");
        $trip->setNbPlace(55);
        $trip->setPrice(30);

        $manager->persist($trip);
        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }
}