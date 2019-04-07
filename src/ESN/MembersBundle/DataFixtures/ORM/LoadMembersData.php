<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 16/04/15
 * Time: 22:12
 */

namespace ESN\MembersBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use ESN\MembersBundle\Entity\Erasmus;
use ESN\MembersBundle\Entity\Member;
use ESN\AdministrationBundle\Entity\University;
use ESN\AdministrationBundle\Entity\Country;


class LoadMembersData extends AbstractFixture implements OrderedFixtureInterface
{
    private $manager;
    private $studies = array("Informatique", "Languages", "Economie", "Psychologie", "Géographie", "Réseau", "Communication");
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager){
        $this->manager = $manager;

        //Create IS Members
        /*for ($i=0 ; $i<20 ; $i++){
            $member = new Member\();
            $member->setName($this->getRandomName());
            $member->setSurname($this->getRandomSurname());
            $member->setPhone($this->getRandomPhoneNumber());
            $member->setSexe($this->getRandomSexe());
            $nationality = $this->getRandomNationality();
            $nationality->addMember($member);
            $university = $this->getRandomUniversity();
            $university->addMember($member);
            $member->setBirthday(new \DateTime());
            $member->setEmail($this->getRandomEmail());
            $member->setInscription(new \DateTime());
            $member->setStudy($this->getRandomStudy());

            $manager->persist($member);
            $manager->flush();
        }

        //Create ESNer Members
        for ($i=0 ; $i<30 ; $i++){
            $member = new Member();
            $member->setName($this->getRandomName());
            $member->setSurname($this->getRandomSurname());
            $member->setPhone($this->getRandomPhoneNumber());
            $member->setSexe($this->getRandomSexe());
            $nationality = $this->getFrenchNationality();
            $nationality->addMember($member);
            $university = $this->getRandomUniversity();
            $university->addMember($member);
            $member->setBirthday(new \DateTime());
            $member->setEmail($this->getRandomEmail());
            $member->setInscription(new \DateTime());
            $member->setStudy($this->getRandomStudy());

            $manager->persist($member);
            $manager->flush();
        }*/
    }

    private function getRandomStudy(){
        return $this->studies[rand(0, count($this->studies)-1)];
    }

    private function getRandomEmail(){
        $tlds = array("com", "net", "gov", "org", "edu", "biz", "info");
        $char = "0123456789abcdefghijklmnopqrstuvwxyz";
        $ulen = mt_rand(5, 10);
        $dlen = mt_rand(7, 17);
        $a = "";
        for ($i = 1; $i <= $ulen; $i++) {
            $a .= substr($char, mt_rand(0, strlen($char)), 1);
        }
        $a .= "@";
        for ($i = 1; $i <= $dlen; $i++) {
            $a .= substr($char, mt_rand(0, strlen($char)), 1);
        }
        $a .= ".";
        $a .= $tlds[mt_rand(0, (sizeof($tlds)-1))];
        return $a;
    }

    private function getRandomName(){
        return $this->cleanString($this->getRandomLineFromeFile("src/ESN/MembersBundle/DataFixtures/TXT/firstname.txt", rand(1, 5494)));
    }

    private function getRandomSurname(){
        $surname = $this->cleanString($this->getRandomLineFromeFile("src/ESN/MembersBundle/DataFixtures/TXT/lastname.txt", rand(1, 88817)));
        return substr($surname ,0, strlen($surname)-1);
    }

    private function cleanString($string){
        $string = preg_replace('/^\s+|\n|\r|\s+$/m', '', $string);
        return $string;
    }

    private function getRandomLineFromeFile($file, $randomNumber){
        $handle = fopen($file, "r");
        if ($handle) {
            $cpt = 0;
            while (($line = fgets($handle)) !== false) {
                if ($cpt == $randomNumber)
                    break;
                $cpt++;
            }

            fclose($handle);
        }
        return $line;
    }

    private function getRandomPhoneNumber(){
        $phonenumber = "06";

        for ($i=0 ; $i<7 ; $i++)
            $phonenumber .= rand(0,9);

        return $phonenumber;
    }

    private function getRandomSexe(){
        $sexe = array("f","m");
        return $sexe[rand(0,1)];
    }

    private function getRandomUniversity(){
        return $this->manager->getRepository('ESNAdministrationBundle:University')->find(rand(92,114));
    }

    private function getRandomNationality(){
        return $this->manager->getRepository('ESNAdministrationBundle:Country')->find(rand(1,192));
    }

    private function getFrenchNationality(){
        return $this->manager->getRepository('ESNAdministrationBundle:Country')->findOneByName("France");
    }

    public function getOrder()
    {
        return 6;
    }
}
