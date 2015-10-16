<?php
/**
 * Created by PhpStorm.
 * User: ylly
 * Date: 14/10/15
 * Time: 21:51
 */

namespace ESN\MembersBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use ESN\AdministrationBundle\Entity\CountryRepository;
use ESN\AdministrationBundle\Entity\PoleRepository;
use ESN\AdministrationBundle\Entity\PostRepository;
use ESN\AdministrationBundle\Entity\UniversityRepository;
use ESN\UserBundle\Entity\UserRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EsnerType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text')
            ->add('lastname','text')
            ->add('post', 'entity' ,
                array('class' => 'ESNAdministrationBundle:Post',
                    'empty_value'  => '',
                    'query_builder' => function(PostRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->orderBy("p.name", "ASC");
                    }
                )
            )
            ->add('pole', 'entity' ,
                array('class' => 'ESNAdministrationBundle:Pole',
                    'empty_value'  => '',
                    'query_builder' => function(PoleRepository $er) {
                        return $er->createQueryBuilder('p')
                            ->orderBy("p.name", "ASC");
                    }
                )
            )
            ->add('facebook_id', 'text',
                array(
                    "required" => false
                )
            )
            ->add('email','email', array("required" => false))
            ->add('mobile','text', array("required" => false))
            ->add('birthdate', 'date', array('widget' => 'single_text'))
            ->add('hasCare', 'checkbox', array("required" => false))
            ->add('erasmusProgramme', 'entity' , array(
                    'required' => false,
                    'class' => 'ESNAdministrationBundle:Country',
                    'empty_value'  => '',
                    'query_builder' => function(CountryRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy("c.name", "ASC");
                    }
                )
            )
            ->add('erasmusyearstart', 'date', array("required" => false))
            ->add('erasmusyearend', 'date', array("required" => false))
            ->add('study', 'text', array("required" => false))
            ->add('address', 'text', array("required" => false))
            ->add('city', 'text', array("required" => false))
            ->add('zipcode', 'number', array("required" => false))
            ->add('university', 'entity' , array(
                    'class' => 'ESNAdministrationBundle:University',
                    'empty_value'  => '',
                    'query_builder' => function(UniversityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy("u.name", "ASC");
                    }
                )
            )
            ->add('mentor', 'entity' , array(
                    'class'       => 'ESNUserBundle:User',
                    'empty_value'  => '',
                    'required' => false,
                    'query_builder' => function(UserRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy("u.firstname", "ASC");
                    }
                )
            )
            ->add('nationality', 'entity', array(
                    'class' => 'ESNAdministrationBundle:Country',
                    'empty_value'  => '',
                    'query_builder' => function(CountryRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy("c.name", "ASC");
                    }
                )
            )
            ->add('sendmail', 'checkbox', array(
                    'mapped' => false,
                    'required' => false
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getName()
    {
        return 'esner_form';
    }
}