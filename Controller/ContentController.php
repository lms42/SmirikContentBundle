<?php

namespace Smirik\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Smirik\ContentBundle\Model\ContentQuery;
use Smirik\ContentBundle\Model\CategoryQuery;

class ContentController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("SmirikContentBundle::index.html.twig", vars={"get"})
     */
    public function indexAction()
    {
      $news = ContentQuery::create()
				->useCategoryQuery()
					->filterByUrlkey('news')
				->endUse()
				->limit(10)
				->orderByCreatedAt('desc')
				->find();
      return array(
        'news' => $news,
      );
    }

    /**
     * @Route("/about", name="about")
     * @Template("SmirikContentBundle::about.html.twig", vars={"get"})
     */
    public function aboutAction()
    {
      return array(
      );
    }
    
    /**
     * @Route("/show/{id}", name="content_show")
     * @Template("SmirikContentBundle:Content:show.html.twig", vars={"get"})
     */
    public function showAction($id)
    {
			$content = ContentQuery::create()->findPk($id);
      
      if (!$content)
      {
        throw $this->createNotFoundException('No content found for id '.$id);
      }
      
      return array(
        'content' => $content,
      );
      
    }
    
    /**
     * @Template("SmirikContentBundle::navigation.html.twig", vars={"get"})
     */
    public function navigationAction()
    {
			$categories = CategoryQuery::create()->filterByNavigation(true)->find();
      return array(
        'categories' => $categories,
      );
    }

    /**
     * @Template("SmirikContentBundle::sidebar.html.twig", vars={"get"})
     */
    public function sidebarAction()
    {
			$content = ContentQuery::create()
				->useCategoryQuery()
					->filterByUrlkey('keynote')
				->endUse()
				->limit(3)
				->find();
      
       return array(
         'content' => $content,
       );
      
    }
    
    /**
     * @Route("/category/{urlkey}", name="category_show")
     */
    public function categoryAction($urlkey)
    {
      $category = CategoryQuery::create()->filterByUrlkey($urlkey)->findOne();;
      if (!$category)
      {
        throw $this->createNotFoundException('No category found for id '.$id);
      }
      
			$content = ContentQuery::create()->filterByCategoryId($category->getId())->limit(10)->orderByCreatedAt('desc')->find();
      
      if ($category->getMode())
      {
        return $this->render('SmirikContentBundle:Category:table.html.twig', array(
          'category' => $category,
          'content'  => $content,
        ));
      } else
      {
        return $this->render('SmirikContentBundle:Category:show.html.twig', array(
          'category' => $category,
          'content'  => $content,
        ));
      }
      
    }
    
}
