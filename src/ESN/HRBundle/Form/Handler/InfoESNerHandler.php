<?php
/**
 * Created by PhpStorm.
 * User: Jérémie Samson | jeremie@ylly.fr
 * Date: 18/04/15
 * Time: 16:02
 */

namespace ESN\HRBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use ESN\HRBundle\Entity\InfoEsner;
use ESN\MembersBundle\Entity\Esner;
use Symfony\Component\Form\Form;
use ESN\MembersBundle\Entity\Member;
use Symfony\Component\HttpFoundation\Request;

class InfoESNerHandler {
    protected $em;
    protected $request;
    protected $form;

    /**
     * Initialize the handler with the form and the request.
     * @param
     * @param Form    $form
     * @param Request $request
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
            $update = false;

            if ($this->form->get('id_esner')->getData()){
                $esner = $this->em->getRepository('ESNMembersBundle:Esner')->find($this->form->get('id_esner')->getData());
                $info_esner = $this->em->getRepository('ESNHRBundle:InfoEsner')->findOneByEsner($esner);

                if ($info_esner)
                    $update = true;
                else
                    $info_esner = new InfoEsner();

                $info_esner->setEsner($esner);
            }

            $info_esner->setComment($this->form->get('comment')->getData());
            $info_esner->setCotisation($this->form->get('cotisation')->getData());

            if (!$update)
                $this->em->persist($info_esner);

            $this->em->flush();

            return true;
        }

        return false;
    }
}