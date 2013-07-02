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
     * @Template("SmirikContentBundle:Content:show.html.twig", vars={"get"})
     */
    public function showAction($id)
    {
        $content = ContentQuery::create()->findPk($id);

        if (!$content) {
            throw $this->createNotFoundException('No content found for id '.$id);
        }

        return array(
            'content' => $content,
        );
    }

    /**
     * @Route("/category/{urlkey}", name="category_show")
     */
    public function categoryAction($urlkey)
    {
        $category = CategoryQuery::create()->filterByUrlkey($urlkey)->findOne();

        if ( ! $category) {
            throw $this->createNotFoundException('No category found for id '.$id);
        }

        $content = ContentQuery::create()
            ->filterByCategoryId($category->getId())
            ->limit(10)
            ->orderByCreatedAt('desc')
            ->find();

        if ($category->getMode()) {
            return $this->render(
                'SmirikContentBundle:Category:table.html.twig',
                array(
                    'category' => $category,
                    'content' => $content,
                )
            );
        } else {
            return $this->render(
                'SmirikContentBundle:Category:show.html.twig',
                array(
                    'category' => $category,
                    'content' => $content,
                )
            );
        }

    }

}
