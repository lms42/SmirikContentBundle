<?php

namespace Smirik\ContentBundle\Form\Type\Base;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parent')
            ->add('title')
            ->add('urlkey')
            ->add('navigation')
            ->add('is_active')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Smirik\ContentBundle\Model\Category',
        );
    }

    public function getName()
    {
        return 'Category';
    }

}

