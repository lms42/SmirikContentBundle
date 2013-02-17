<?php

namespace Smirik\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Smirik\PropelAdminBundle\Controller\AdminAbstractController as AbstractController;

class AdminCategoryController extends AbstractController
{
	
	public $layout = 'SmirikAdminBundle::layout.html.twig';
	public $name   = 'categories';
	public $bundle = 'SmirikContentBundle';

	public function getQuery()
	{
		return \Smirik\ContentBundle\Model\CategoryQuery::create();
	}
	
	public function getForm()
	{
		return new \Smirik\ContentBundle\Form\Type\CategoryType;
	}
	
	public function getObject()
	{
		return new \Smirik\ContentBundle\Model\Category;
	}

}

