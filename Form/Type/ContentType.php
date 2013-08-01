<?php

namespace Smirik\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Smirik\PropelAdminBundle\Form\DataTransformer\FileToTextTransformer;

class ContentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new FileToTextTransformer();
        
        $builder
            ->add('category', 'model', array(
                  'class'    => 'Smirik\ContentBundle\Model\Category',
                  'multiple' => false,
                  'required' => false,
            ))
            ->add('title')
            ->add('description', 'ckeditor')
            ->add('text', 'ckeditor')
            ->add('file', 'file')
            ->add($builder->create('file', 'file', array('required' => false))->addModelTransformer($transformer))
            ->add('urlkey')
            ->add('is_active')
            ->add('weight');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Smirik\ContentBundle\Model\Content'
            )
        );
    }

    public function getName()
    {
        return 'Content';
    }

}

