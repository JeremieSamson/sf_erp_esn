<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 15/04/15
 * Time: 22:45
 */

namespace ESN\MembersBundle\Form;

use Doctrine\ORM\EntityManager;
use ESN\AdministrationBundle\Entity\University;
use ESN\MembersBundle\Entity\Erasmus;
use ESN\MembersBundle\Entity\Esner;
use ESN\MembersBundle\Entity\EsnerRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EsnerUpdateType extends AbstractType{
    private $em;
    private $esner;

    public function __construct(EntityManager $em, Esner $esner)
    {
        $this->em = $em;
        $this->esner = $esner;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $dataUni = 0;
        $dataCountry = 0;
        $erasmusCountry = 0;
        if ($this->esner != null){
            $erasmusCountry = $this->esner->getErasmusProgramme();
            $dataCountry = $this->esner->getMember()->getNationality();
            $dataUni = $this->esner->getMember()->getUniversity();
            $dataPole = $this->esner->getPole();
            $dataPost = $this->esner->getPost();
            $dataMentor = $this->esner->getMentor();
        }

        $builder->add('name', 'text')
            ->add('surname','text')
            ->add('post', 'entity' ,
                array('class' => 'ESNAdministrationBundle:Post',
                    'choices' => $this->em->getRepository('ESNAdministrationBundle:Post')->findAll(),
                    'data' => $dataPost)
            )
            ->add('pole', 'entity' ,
                array('class' => 'ESNAdministrationBundle:Pole',
                    'choices' => $this->em->getRepository('ESNAdministrationBundle:Pole')->findAll(),
                    'data' => $dataPole)
            )
            ->add('facebook_id', 'text', array("required" => false, "data" => $this->esner->getMember()->getFacebookId()))
            ->add('email','email', array("required" => false))
            ->add('phone','text', array("required" => false))
            ->add('birthday', 'date', array('widget' => 'single_text'))
            ->add('hasCare', 'checkbox', array("required" => false))
            ->add('erasmus', 'entity' ,
                array('class' => 'ESNAdministrationBundle:Country',
                    'choices' => $this->em->getRepository('ESNAdministrationBundle:Country')->findAll(),
                    'data' => $erasmusCountry
                )
            )
            ->add('erasmusyearstart', 'date', array("required" => false))
            ->add('erasmusyearend', 'date', array("required" => false))
            ->add('study', 'text', array("required" => false))
            ->add('address', 'text', array("required" => false))
            ->add('city', 'text', array("required" => false))
            ->add('zipcode', 'number', array("required" => false))
            ->add('id' , 'hidden', array('attr' => array( 'value' => $this->esner->getId())))
            ->add('university', 'entity' ,
                array('class' => 'ESNAdministrationBundle:University',
                    'choices' => $this->em->getRepository('ESNAdministrationBundle:University')->findAll(),
                    'data' => $dataUni)
            )
            ->add('mentor', 'entity' ,
                array('class'       => 'ESNMembersBundle:Esner',
                      'data'        => $dataMentor,
                      'empty_value'  => '',
                      'query_builder' => function(EsnerRepository $er) {
                            return $er->createQueryBuilder('e')
                                ->leftJoin("e.member", "m")
                                ->orderBy("m.name", "ASC");
                      }
                )
            )
            ->add('country', 'entity' ,
                array('class' => 'ESNAdministrationBundle:Country',
                    'choices' => $this->em->getRepository('ESNAdministrationBundle:Country')->findAll(),
                    'data' => $dataCountry
                )
            );
    }


    public function getName()
    {
        return 'update_esners';
    }
}