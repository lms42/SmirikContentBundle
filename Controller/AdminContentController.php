<?php

namespace Smirik\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Smirik\PropelAdminBundle\Controller\AdminAbstractController as AbstractController;

class AdminContentController extends AbstractController
{
	
	public $layout = 'SmirikAdminBundle::layout.html.twig';
	public $name   = 'content';
	public $bundle = 'SmirikContentBundle';

	public function getQuery()
	{
		return \Smirik\ContentBundle\Model\ContentQuery::create();
	}
	
	public function getForm()
	{
		return new \Smirik\ContentBundle\Form\Type\ContentType;
	}
	
	public function getObject()
	{
		return new \Smirik\ContentBundle\Model\Content;
	}

}

