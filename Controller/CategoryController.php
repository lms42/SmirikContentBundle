<?php

namespace Smirik\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Smirik\ContentBundle\Model\ContentQuery;
use Smirik\ContentBundle\Model\CategoryQuery;

/**
 * @Route("/categories")
 */
class CategoryController extends Controller
{

    /**
     * @Route("/{urlkey}", name="category_index")
     * @Route("/{urlkey}/{page}", name="category_index_paginate")
     */
    public function indexAction($urlkey, $page = 1)
    {
        $category = CategoryQuery::create()->filterByUrlkey($urlkey)->findOne();

        if (!$category) {
            throw $this->createNotFoundException('No category found for id '.$id);
        }

        $content = $this->get('content.manager')->category($category)->paginate($page, 15);
        $categories = $this->get('category.manager')->main();

        $response = array(
            'category'   => $category,
            'categories' => $categories,
            'content'    => $content,
        );

        if ($category->getMode()) {
            return $this->render('SmirikContentBundle:Category:index_table.html.twig', $response);
        }
        return $this->render('SmirikContentBundle:Category:index.html.twig', $response);
    }

}
