<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 22:53
 */

namespace ESN\MembersBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use ESN\UserBundle\Entity\User;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

class ErasmusHandler
{
    protected $em;
    protected $request;
    protected $form;

    /**
     * Initialize the handler with the form and the request.
     * @param
     * @param Form    $form
     * @param Request $request
     * @param $mailer
     */
    public function __construct(EntityManager $em, Form $form, Request $request)
    {
        $this->em = $em;
        $this->form = $form;
        $this->request = $request;
    }

    public function process()
    {
        if ('POST' == $this->request->getMethod()) {

            /** @var User $user */
            $user = $this->form->getData();

            // Check if user already registred
            if ($user->getEmail()){
                $user_db = $this->em->getRepository('ESNUserBundle:User')->findOneBy(array("email" => $user->getEmail()));

                if ($user_db){
                    $this->form->get('email')->addError(new FormError('Email already used'));
                    return false;
                }
            }

            if (!$user->getId()){
                $username = ($user->getEmail()) ? $user->getEmail() : strtolower($user->getFirstname() . "_" .$user->getLastname());

                $user->setUsername($username);
                $user->setRandomPassword();
                $user->setEsner(false);
                $user->setEnabled(true);

                $this->em->persist($user);
            }

            $this->em->flush();

            return true;
        }

        return false;
    }

    protected function onSuccess(){
    }
}