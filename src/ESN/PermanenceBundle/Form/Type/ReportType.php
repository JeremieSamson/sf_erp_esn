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
            ->add('amountBefore', 'integer', array(
                'attr' => array(
                    'readonly' => true,
                    'class' => 'span3'
                )
            ))
            ->add('amountAfter', 'integer', array(
                'attr' => array(
                    'readonly' => true,
                    'class' => 'span3'
                )
            ))
            ->add('sellCard', 'integer', array(
                'attr' => array(
                    'class' => 'span3',
                    'min' => 0
                )
            ))
            ->add('availableCard', 'integer', array(
                'attr' => array(
                    'readonly' => true,
                    'class' => 'span3',
                    'min' => 1
                )
            ))
            ->add('comments', 'textarea')
            ;
    }

    public function getName()
    {
        return 'form_report';
    }
}