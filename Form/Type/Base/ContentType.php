<?php

namespace Smirik\ContentBundle\Form\Type\Base;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContentType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category')
            ->add('title')
            ->add('description')
            ->add('text')
            ->add('urlkey')
            ->add('is_active')
            ->add('weight')
        ;
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Smirik\ContentBundle\Model\Content',
        );
    }

    public function getName()
    {
        return 'Content';
    }

}

