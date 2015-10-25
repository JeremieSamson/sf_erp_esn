<?php

namespace ESN\MembersBundle\Command;

use Doctrine\ORM\EntityManager;
use ESN\AdministrationBundle\Entity\Country;
use ESN\AdministrationBundle\Entity\Pole;
use ESN\AdministrationBundle\Entity\Post;
use ESN\AdministrationBundle\Entity\University;
use ESN\MembersBundle\Entity\Erasmus;
use ESN\MembersBundle\Entity\Esner;
use ESN\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('esn:members:import')
            ->setDescription('Export all members')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $path = $this->getContainer()->getParameter("kernel.cache_dir");
        $tmp_file = $path . "/esners.csv";

        $fichier_a_ouvrir = fopen ($tmp_file, "a+");
        $contenu = file_get_contents($tmp_file);

        $esners = explode("<br/>", $contenu);

        foreach($esners as $esner){
            $esner = explode(',', $esner);

            $user_db = null;
            if ($esner[2] != ""){
                $user_db = $em->getRepository('ESNUserBundle:User')->findOneBy(array("email" => $esner[2]));
            }


            if (!$user_db)
                $user = new User();
            else{
                $output->writeln("User " . $user_db . " already exist, next iteration");
                continue;
            }

            $user->setEnabled(true);
            $user->setEsner(true);
            $user->setRandomPassword();

            $output->writeln("Starting : " .$esner[0] . " " . $esner[1]);
            $user->setFirstname($esner[0]);
            $user->setLastname($esner[1]);

            $user->setUsername($esner[2]);
            $user->setUsernameCanonical($esner[2]);
            $user->setEmail($esner[2]);

            $user->setAddress($esner[3]);
            $user->setCity($esner[4]);
            $user->setZipcode($esner[5]);

            if ($esner[6] != "")
                $user->setBirthdate(\DateTime::createFromFormat("Y-m-d H:i:s", $esner[6]));

            $user->setGender($esner[7]);
            $user->setMobile($esner[8]);

            /** @var Pole $pole */
            $pole = $em->getRepository('ESNAdministrationBundle:Pole')->findOneBy(array("name" => $esner[9]));
            if ($pole)
                $pole->addEsner($user);

            /** @var Post $poste */
            $poste = $em->getRepository('ESNAdministrationBundle:Post')->findOneBy(array("name" => $esner[10]));
            if ($poste)
                $poste->addEsner($user);

            $user->setHasCare(($esner[11]) ? $esner[11] : false);
            $user->setActive(($esner[12]) ? $esner[12] : false);

            /** @var Country $erasmusprogramme */
            $erasmusprogramme = $em->getRepository('ESNAdministrationBundle:Country')->findOneBy(array("name" => $esner[13]));

            if ($erasmusprogramme)
                $erasmusprogramme->addEsner($user);

            if ($esner[14] != "")
                $user->setErasmusYearStart(\DateTime::createFromFormat("Y-m-d H:i:s", $esner[14]));

            if ($esner[15] != "")
                $user->setErasmusYearEnd(\DateTime::createFromFormat("Y-m-d H:i:s", $esner[15]));

            /** @var User $mentor */
            $mentor = $em->getRepository('ESNUserBundle:User')->findOneBy(array("lastname" => $esner[16]));

            if ($mentor){
                $mentor->addMentee($user);
            }

            /** @var University $uni */
            $uni = $em->getRepository('ESNAdministrationBundle:University')->findOneBy(array("name" => $esner[17]));

            if ($uni){
                $uni->addUser($user);
            }

            $user->setStudy($esner[18]);

            /** @var Country $nationality */
            $nationality = $em->getRepository('ESNAdministrationBundle:Country')->find($esner[19]);

            if ($nationality){
                $nationality->addUser($user);
            }

            $user->setFacebookId($esner[20]);

            if (!$user_db){
                $output->writeln("ESNer " . $user . " Ajouté");
                $em->persist($user);
            }else{
                $output->writeln("ESNer " . $user . " Mis à jours");
            }

            $em->flush();

        }

        $fichier_a_ouvrir = fopen ($tmp_file, "a+");
        $contenu = file_get_contents($tmp_file);

        $erasmuss= explode("<br/>", $contenu);

        foreach($erasmuss as $erasmus){
            $esner = explode(',', $erasmus);

            $user_db = null;
            if ($esner[2] != ""){
                $user_db = $em->getRepository('ESNUserBundle:User')->findOneBy(array("email" => $esner[2]));
            }


            if (!$user_db)
                $user = new User();
            else{
                $output->writeln("User " . $user_db . " already exist, next iteration");
                continue;
            }

            $user->setEnabled(true);
            $user->setEsner(false);
            $user->setRandomPassword();

            $user->setFirstname($esner[0]);
            $user->setLastname($esner[1]);

            $user->setUsername($esner[2]);
            $user->setUsernameCanonical($esner[2]);
            $user->setEmail($esner[2]);

            if ($esner[3] != "")
                $user->setBirthdate(\DateTime::createFromFormat("Y-m-d H:i:s", $esner[3]));

            $user->setGender($esner[4]);
            $user->setMobile($esner[5]);

            if ($esner[6] != "")
                $user->setArrivalDate(\DateTime::createFromFormat("Y-m-d H:i:s", $esner[6]));

            $user->setEsncard($esner[7]);

            if ($esner[8] != ""){
                $user->setLeavingDate(\DateTime::createFromFormat("Y-m-d H:i:s", $esner[8]));
            }

            /** @var University $uni */
            $uni = $em->getRepository('ESNAdministrationBundle:University')->findOneBy(array("name" => $esner[9]));

            if ($uni){
                $uni->addUser($user);
            }

            $user->setStudy($esner[10]);

            /** @var Country $nationality */
            $nationality = $em->getRepository('ESNAdministrationBundle:Country')->find($esner[11]);

            if ($nationality){
                $nationality->addUser($user);
            }

            $user->setFacebookId($esner[12]);

            if (!$user_db){
                $output->writeln("IS " . $user . " Ajouté");
                $em->persist($user);
            }else{
                $output->writeln("IS " . $user . " Mis à jours");
            }

            $em->flush();


        }

        $output->writeln("Commande terminé");
    }
}