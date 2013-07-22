<?php

namespace Smirik\ContentBundle\Model;

use Smirik\ContentBundle\Model\om\BaseContentQuery;


/**
 * Skeleton subclass for performing query and update operations on the 'content' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.vendor.bundles.Smirik.ContentBundle.Model
 */
class ContentQuery extends BaseContentQuery {

	public function orderByCategory($type)
	{
		return $this
			->useCategoryQuery()
				->orderByTitle($type)
			->endUse()
		;
	}
    
    public function lastNews($limit)
    {
        return $this
            ->useCategoryQuery()
            ->filterByUrlkey('news')
            ->endUse()
            ->limit(10)
            ->orderByCreatedAt('desc')
        ;
    }
    
	
} // ContentQuery
