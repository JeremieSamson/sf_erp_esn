<?php
/**
 * Created by PhpStorm.
 * User: ylly
 * Date: 16/10/15
 * Time: 19:01
 */

namespace ESN\PermanenceBundle\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ReportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amountBefore', 'integer')
            ->add('amountAfter', 'integer')
            ->add('sellCard', 'integer')
            ->add('availableCard', 'integer')
            ->add('comments', 'textarea')
            ;
    }

    public function getName()
    {
        return 'form_report';
    }
}