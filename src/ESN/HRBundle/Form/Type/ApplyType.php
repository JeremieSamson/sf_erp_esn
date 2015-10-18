<?php
/**
 * Created by PhpStorm.
 * User: Spider
 * Date: 12/04/15
 * Time: 21:04
 */

namespace ESN\HRBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use ESN\AdministrationBundle\Entity\CountryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ApplyType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text')
            ->add('lastname','text')
            ->add('birthdate', 'date', array('widget' => 'single_text'))
            ->add('nationality', 'entity', array(
                    'class' => 'ESNAdministrationBundle:Country',
                    'empty_value'  => '',
                    'query_builder' => function(CountryRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy("c.name", "ASC");
                    }
                )
            )
            ->add('email','email', array("required" => false))
            ->add('facebook_id', 'text', array("required" => false))
            ->add('student', 'checkbox', array("required" => false))
            ->add('olderasmus', 'checkbox', array("required" => false))
            ->add('motivation', 'textarea', array("required" => false))
            ->add('skill', 'textarea', array("required" => false))
            ->add('olderasmus', 'checkbox', array("required" => false))
            ->add('knowesn', 'checkbox', array("required" => false))
        ;
    }

    public function getName()
    {
        return 'form_apply';
    }
}