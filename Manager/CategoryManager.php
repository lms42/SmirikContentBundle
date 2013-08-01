<?php

namespace Smirik\ContentBundle\Manager;

use Smirik\ContentBundle\Model\CategoryQuery;

class CategoryManager
{

    public function main()
    {
        return CategoryQuery::create()
            ->filterByPid(1)
            ->find()
        ;
    }
    
}