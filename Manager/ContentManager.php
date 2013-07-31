<?php

namespace Smirik\ContentBundle\Manager;

use Smirik\ContentBundle\Model\ContentQuery;

class ContentManager
{
    /**
     * Get latest content rows
     * @param  int  [$limit=null]
     * @return mixed
     */
    public function last($limit = null)
    {
        return ContentQuery::create()
            ->filterByIsActive(true)
            ->orderByCreatedAt('desc')
            ->limit($limit)
            ->find()
        ;
    }
    
    public function category($category)
    {
        return ContentQuery::create()
            ->filterByCategoryId($category->getId())
            ->orderByCreatedAt('desc')
        ;
    }
    
}