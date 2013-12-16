<?php

namespace Smirik\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Smirik\ContentBundle\Model\ContentQuery;
use Smirik\ContentBundle\Model\CategoryQuery;
//use Smirik\CourseBundle\Model\CourseQuery;
//use Smirik\CourseBundle\Model\UserLessonQuery;

/**
 * @Route("/content")
 */
class ContentController extends Controller
{
    /**
     * @Route("/{id}", name="content_index")
     * @Template("SmirikContentBundle:Content:index.html.twig", vars={"get"})
     */
    public function indexAction($id)
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

}
