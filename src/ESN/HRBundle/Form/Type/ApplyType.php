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
            ->add('birthdate', 'date', array(
                'widget' => 'single_text',
                'html5'  => false,
                'format' => 'd/MM/y',
                'attr' => array(
                    'class' => 'datetimepicker'
                )
            ))
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
            ->add('facebook_id', 'text', array("required" => true))
            ->add('mobile', 'text', array("required" => true))
            ->add('student', 'checkbox', array("required" => false))
            ->add('availabletime', 'choice', array(
                'required' => true,
                'choices' => array(
                    '2' => 'Moins de 4 heures',
                    '4' => '4 heures',
                    '6' => '6 heures',
                    '8' => '8 heures',
                    '10' => '10 heures',
                    '12' => '12 heures',
                    '15' => 'Plus de 12 heures'
                ),
                'expanded' => true,
                'multiple' => false
            ))
            ->add('languages', 'entity', array(
                    'class' => 'ESNAdministrationBundle:Country',
                    'empty_value'  => '',
                    'multiple' => true,
                    'query_builder' => function(CountryRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy("c.name", "ASC");
                    },
                )
            )
            ->add('motivation', 'textarea', array("required" => false))
            ->add('skill', 'textarea', array("required" => false))
            ->add('olderasmus', 'checkbox', array("required" => false))
            ->add('knowesn', 'textarea', array("required" => false))
        ;
    }

    public function getName()
    {
        return 'form_apply';
    }
}
