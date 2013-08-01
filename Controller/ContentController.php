<?php

namespace Smirik\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Smirik\ContentBundle\Model\ContentQuery;
use Smirik\ContentBundle\Model\CategoryQuery;
//use Smirik\CourseBundle\Model\CourseQuery;
//use Smirik\CourseBundle\Model\UserLessonQuery;

class ContentController extends Controller
{
    /**
     * @Route("/show/{id}", name="content_show")
     * @Template("SmirikContentBundle:Content:index.html.twig", vars={"get"})
     */
    public function showAction($id)
    {
        $content = ContentQuery::create()->findPk($id);

        if (!$content) {
            throw $this->createNotFoundException('No content found for id '.$id);
        }
        
        $categories = $this->get('category.manager')->main();

        return array(
            'content'    => $content,
            'categories' => $categories,
        );
    }

    /**
     * @Route("/category/{urlkey}", name="category_show")
     * @Route("/category/{urlkey}/{page}", name="category_show_paginate")
     */
    public function categoryAction($urlkey, $page = 1)
    {
        $category = CategoryQuery::create()->filterByUrlkey($urlkey)->findOne();

        if ( ! $category) {
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
