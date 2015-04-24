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
    private $colors = array("219BF2", "DD007E", "E96800", "201C85", "70B918");
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $pole = new Pole();
        $pole->setName("Pole Web");
        $pole->setDescription("Pole des geeks");
        $pole->setColor($this->getRandomColor());
        $manager->persist($pole);

        $pole = new Pole();
        $pole->setName("Pole Sport");
        $pole->setDescription("Pole des sportif");
        $pole->setColor($this->getRandomColor());
        $manager->persist($pole);

        $pole = new Pole();
        $pole->setName("Pole Culture");
        $pole->setDescription("Pole des cultivé");
        $pole->setColor($this->getRandomColor());
        $manager->persist($pole);

        $pole = new Pole();
        $pole->setName("Pole Soirées");
        $pole->setDescription("Pole des chouilleurs");
        $pole->setColor($this->getRandomColor());
        $manager->persist($pole);

        $pole = new Pole();
        $pole->setName("Pole Partenariat");
        $pole->setDescription("Pole des vendeurs de rêve");
        $pole->setColor($this->getRandomColor());
        $manager->persist($pole);

        $pole = new Pole();
        $pole->setName("Pole Communication");
        $pole->setDescription("Pole des acro a Facebook");
        $pole->setColor($this->getRandomColor());
        $manager->persist($pole);
        $manager->flush();
    }

    public function getRandomColor(){
        return $this->colors[rand(0, count($this->colors)-1)];
    }

    public function getOrder()
    {
        return 3;
    }
}