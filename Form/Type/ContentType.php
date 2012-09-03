<?php

namespace Smirik\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ContentType extends AbstractType
{
  
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
			->add('category', 'model', array('class' => 'Smirik\ContentBundle\Model\Category'))
      ->add('title')
      ->add('description', 'textarea')
      ->add('text', 'textarea')
      ->add('urlkey')
      ->add('is_active')
      ->add('weight')
      ->add('file', 'file', array('required' => false))
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

