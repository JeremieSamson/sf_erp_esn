<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 22:53
 */

namespace ESN\MembersBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use ESN\MembersBundle\Entity\Erasmus;
use Symfony\Component\Form\Form;
use ESN\MembersBundle\Entity\Member;
use Symfony\Component\HttpFoundation\Request;

class ErasmusUpdateHandler
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
        if ($this->form->isValid()) {
            if ('POST' == $this->request->getMethod()) {

                $erasmus = $this->em->getRepository('ESNMembersBundle:Erasmus')->find($this->form->get('id')->getData());
                $identity_erasmus = $this->em->getRepository('ESNMembersBundle:Member')->find($erasmus->getMember());
                $identity_erasmus->setName($this->form->get('name')->getData());
                $identity_erasmus->setSurname($this->form->get('surname')->getData());
                $identity_erasmus->setEmail($this->form->get('email')->getData());
                $identity_erasmus->setPhone($this->form->get('phone')->getData());
                $identity_erasmus->setStudy($this->form->get('study')->getData());
                $identity_erasmus->setBirthday($this->form->get('birthday')->getData());
                $identity_erasmus->setUniversity($this->form->get('university')->getData());
                $identity_erasmus->setNationality($this->form->get('country')->getData());

                $erasmus->setMember($identity_erasmus);
                $erasmus->setEsncard($this->form->get('esncard')->getData());
                $erasmus->setArrivalDate($this->form->get('arrivalDate')->getData());
                $erasmus->setLeavingDate($this->form->get('leavingDate')->getData());

                $this->em->flush();

                return true;
            }
        }
        return false;
    }

    protected function onSuccess(){
    }
}