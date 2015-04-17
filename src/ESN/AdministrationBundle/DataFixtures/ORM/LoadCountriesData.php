<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 16/04/15
 * Time: 21:54
 */


namespace ESN\AdministrationBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadCountriesData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $filename = "src/ESN/AdministrationBundle/DataFixtures/SQL/Country.sql";

        $sql = file_get_contents($filename);
        $manager->getConnection()->exec($sql);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}