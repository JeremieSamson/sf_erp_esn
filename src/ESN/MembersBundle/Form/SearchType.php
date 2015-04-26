<?php
/**
 * Created by PhpStorm.
 * User: Jérémie Samson | jeremie@ylly.fr
 * Date: 24/04/15
 * Time: 16:19
 */

namespace ESN\MembersBundle\Form;

use Doctrine\ORM\EntityManager;
use ESN\AdministrationBundle\Entity\Pole;
use ESN\MembersBundle\Entity\Erasmus;
use ESN\MembersBundle\Entity\Esner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class SearchType extends AbstractType
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('university', 'entity' ,
                array('class' => 'ESNAdministrationBundle:University',
                    'empty_value' => '',
                    'choices' => $this->em->getRepository('ESNAdministrationBundle:University')->findAll()
                )
            )
            ->add('country', 'entity' ,
                array('class' => 'ESNAdministrationBundle:Country',
                    'empty_value' => '',
                    'choices' => $this->em->getRepository('ESNAdministrationBundle:Country')->findAll()
                )
            )
            ->add('pole', 'entity' ,
                array('class' => 'ESNAdministrationBundle:Pole',
                    'empty_value' => '',
                    'choices' => $this->em->getRepository('ESNAdministrationBundle:Pole')->findAll()
                )
            );
    }

    public function getName()
    {
        return 'search_filter';
    }
}