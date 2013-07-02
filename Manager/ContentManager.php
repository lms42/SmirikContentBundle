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
            ->orderByUpdatedAt()
            ->limit($limit)
            ->find()
        ;
    }
}