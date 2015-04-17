<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 16/04/15
 * Time: 22:07
 */

namespace ESN\AdministrationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ESN\AdministrationBundle\Entity\Pole;
use ESN\AdministrationBundle\Entity\Trip;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadPoleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $pole = new Pole();
        $pole->setName("Pole Web");
        $pole->setDescription("Pole des geeks");
        $pole->setNbMembers(30);
        $manager->persist($pole);

        $pole = new Pole();
        $pole->setName("Pole Sport");
        $pole->setDescription("Pole des sportif");
        $pole->setNbMembers(30);
        $manager->persist($pole);

        $pole = new Pole();
        $pole->setName("Pole Culture");
        $pole->setDescription("Pole des cultivé");
        $pole->setNbMembers(30);
        $manager->persist($pole);

        $pole = new Pole();
        $pole->setName("Pole Soirées");
        $pole->setDescription("Pole des chouilleurs");
        $pole->setNbMembers(30);
        $manager->persist($pole);

        $pole = new Pole();
        $pole->setName("Pole Partenariat");
        $pole->setDescription("Pole des vendeurs de rêve");
        $pole->setNbMembers(30);
        $manager->persist($pole);

        $pole = new Pole();
        $pole->setName("Pole Communication");
        $pole->setDescription("Pole des acro a Facebook");
        $pole->setNbMembers(30);
        $manager->persist($pole);
        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}