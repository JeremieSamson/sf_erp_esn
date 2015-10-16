<?php

namespace ESN\HRBundle\Command;

/**
 * Created by PhpStorm.
 * User: ylly
 * Date: 16/10/15
 * Time: 18:04
 */

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use ESN\HRBundle\Entity\EsnerFollow;
use ESN\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class TrialCommand
 *
 * @package ESN\HRBundle\Command
 */
class TrialCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('esn:user:trials')
            ->setDescription('Send email when trial finish today')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager em */
        $em = $this->getContainer()->get('doctrine')->getManager();

        $users = $em->getRepository('ESNUserBundle:User')->findBy(array("esner" => 1));

        $concerned_users = new ArrayCollection();
        /** @var User $user */
        foreach($users as $user){

            /** @var EsnerFollow $follow */
            $follow = $user->getFollow();
            if ($follow){
                $trial = $follow->getTrialstarted();
                $end_trial = $trial;
                date_add($trial, date_interval_create_from_date_string('21 days'));
                $now = new \DateTime();

                if ($end_trial->format('d/m/Y') == $now->format('d/m/Y')){
                    $concerned_users->add($user);
                }
            }
        }

        /** @var User $concerned_user */
        foreach($concerned_users as $concerned_user){
            $message = \Swift_Message::newInstance()
                ->setSubject('[ESN Lille][ERP] Periode d\'essaie terminé pour ' . $concerned_user->getFullname())
                ->setFrom($this->getContainer()->getParameter('mailer_from'))
                ->setTo($user->getEmail())
                ->setBody(
                    $this->getContainer()->get('templating')->render(
                        'ESNHRBundle:Emails:trial_ended.html.twig',
                        array('user' => $concerned_user)
                    ),
                    'text/html'
                )
            ;
            $this->getContainer()->get('mailer')->send($message);
        }
    }
}