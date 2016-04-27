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
use Symfony\Component\Translation\Translator;

class ReportType extends AbstractType
{
    /**
     * @var Translator
     */
    private $translator;

    public function __construct($translator) {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('amountBefore', 'integer', array(
                'attr' => array(
                    'readonly' => true,
                    'class' => 'span3'
                )
            ))
            ->add('frequentation', 'integer', array(
                'attr' => array(
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
            ->add('fivty', 'integer', array(
                'attr' => array(
                    'class' => 'span1',
                    'min' => 0
                )
            ))
            ->add('twenty', 'integer', array(
                'attr' => array(
                    'class' => 'span1',
                    'min' => 0
                )
            ))
            ->add('ten', 'integer', array(
                'attr' => array(
                    'class' => 'span1',
                    'min' => 0
                )
            ))
            ->add('five', 'integer', array(
                'attr' => array(
                    'class' => 'span1',
                    'min' => 0
                )
            ))
            ->add('two', 'integer', array(
                'attr' => array(
                    'class' => 'span1',
                    'min' => 0
                )
            ))
            ->add('one', 'integer', array(
                'attr' => array(
                    'class' => 'span1',
                    'min' => 0
                )
            ))
            ->add('fivtycent', 'integer', array(
                'attr' => array(
                    'class' => 'span1',
                    'min' => 0
                )
            ))
            ->add('twentycent', 'integer', array(
                'attr' => array(
                    'class' => 'span1',
                    'min' => 0
                )
            ))
            ->add('tencent', 'integer', array(
                'attr' => array(
                    'class' => 'span1',
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