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

class RecruiterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('esner', null)
        ;
    }

    public function getName()
    {
        return 'form_add_recruiter';
    }
}