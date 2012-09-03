<?php

namespace Smirik\ContentBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType
{
  
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
			->add('parent', 'model', array(
					    	'class' => 'Smirik\ContentBundle\Model\Category',
					    ))
      ->add('title')
      ->add('navigation')
      ->add('is_active')
      ->add('urlkey')
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

