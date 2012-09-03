<?php

namespace Smirik\ContentBundle\Model;

use Smirik\ContentBundle\Model\om\BaseCategory;


/**
 * Skeleton subclass for representing a row from the 'categories' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.vendor.bundles.Smirik.ContentBundle.Model
 */
class Category extends BaseCategory {

	public function setParent($parent)
	{
		return $this->setCategoryRelatedByPid($parent);
	}

	public function getParent()
	{
		return $this->getCategoryRelatedByPid();
	}
	
	public function __toString()
	{
		return $this->getTitle();
	}

} // Category
