<?php

namespace Smirik\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Smirik\PropelAdminBundle\Controller\AdminAbstractController as AbstractController;

use Smirik\PropelAdminBundle\Column\Column;
use Smirik\PropelAdminBundle\Column\CollectionColumn;
use Smirik\PropelAdminBundle\Action\Action;
use Smirik\PropelAdminBundle\Action\ObjectAction;
use Smirik\PropelAdminBundle\Action\SingleAction;

class AdminCategoryController extends AbstractController
{
	
	public $layout = 'SmirikContentBundle:Admin:layout.html.twig';
	public $name   = 'categories';

	public function setup()
	{
		$this->configure(array(
								     array('name' => 'id', 'label' => 'Id', 'type' => 'integer', 'options' => array(
												 'editable' => false,
												 'listable' => true,
												 'sortable' => true,
												 'filterable' => true)),
		                 array('name' => 'parent', 'label' => 'Parent', 'type' => 'string', 'options' => array(
											 'editable' => true,
											 'listable' => true,
											 'sortable' => true,
											 'filterable' => true)),
										 array('name' => 'title', 'label' => 'Title', 'type' => 'string', 'options' => array(
											 'editable' => true,
											 'listable' => true,
											 'sortable' => true,
											 'filterable' => true)),
										 array('name' => 'navigation', 'label' => 'Navigation', 'type' => 'boolean', 'options' => array(
											 'editable' => true,
											 'listable' => true,
											 'sortable' => true,
											 'filterable' => true)),
										 array('name' => 'is_active', 'label' => 'Enabled', 'type' => 'boolean', 'options' => array(
											 'editable' => true,
											 'listable' => true,
											 'sortable' => true,
											 'filterable' => true)),
										 array('name' => 'urlkey', 'label' => 'Urlkey', 'type' => 'string', 'options' => array(
											 'editable' => true,
											 'listable' => false,
											 'sortable' => false,
											 'filterable' => false))
		                 ),
		                 array('new' => new SingleAction('New', 'new', 'admin_categories_new', true),
											'edit' => new ObjectAction('Edit', 'edit', 'admin_categories_edit', true),
											'delete' => new ObjectAction('Delete', 'delete', 'admin_categories_delete', true, true))
		                );
	}

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

