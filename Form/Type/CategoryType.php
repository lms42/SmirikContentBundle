<?php

namespace Smirik\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parent', 'model', array(
                'class'    => 'Smirik\ContentBundle\Model\Category',
                'multiple' => false,
                'required' => false,
            ))
            ->add('title')
            ->add('urlkey')
            ->add('navigation')
            ->add('is_active')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Smirik\ContentBundle\Model\Category'
            )
        );
    }

    public function getName()
    {
        return 'Category';
    }

}

