<?php

namespace Smirik\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Smirik\ContentBundle\Model\ContentQuery;
use Smirik\ContentBundle\Model\CategoryQuery;
use Smirik\CourseBundle\Model\CourseQuery;
use Smirik\CourseBundle\Model\UserLessonQuery;

class ContentController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("SmirikContentBundle:Default:index.html.twig", vars={"get"})
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
     * @Template("SmirikContentBundle:Default:about.html.twig", vars={"get"})
     */
    public function aboutAction()
    {
        return array();
    }

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
     * @Template("SmirikContentBundle:Default:navigation.html.twig", vars={"get"})
     */
    public function navigationAction()
    {
        $user = $this->getUser();
        $categories = CategoryQuery::create()->filterByNavigation(true)->find();

        $courses = false;
        if (is_object($user)) {
            $courses = CourseQuery::create()
                ->useUserCourseQuery()
                ->filterByUserId($user->getId())
                ->endUse()
                ->find();
        }
        $csrf = $this->container->get('form.csrf_provider')->generateCsrfToken('authenticate');
        return array(
            'categories' => $categories,
            'courses' => $courses,
            'csrf' => $csrf,
        );
    }

    /**
     * @Template("SmirikContentBundle:Default:sidebar.html.twig", vars={"get"})
     */
    public function sidebarAction()
    {
        // $cm = $this->get('course.manager');
        // $user = $this->getUser();
        // $courses_ids = array();
        // 
        // if (is_object($user)) {
        //     $courses_ids = CourseQuery::create()
        //         ->select('Id')
        //         ->useUserCourseQuery()
        //         ->filterByUserId($user->getId())
        //         ->endUse()
        //         ->find()
        //         ->toArray();
        // }
        // 
        // $last_lessons = array();
        // foreach ($courses_ids as $id) {
        //     $user_lesson = UserLessonQuery::create()
        //         ->filterByUserId($user->getId())
        //         ->filterByCourseId($id)
        //         ->joinLesson()
        //         ->joinCourse()
        //         ->orderByStartedAt('desc')
        //         ->findOne();
        //     if ($user_lesson) {
        //         $last_lessons[] = $user_lesson;
        //     }
        // }
        // 
        // $content = ContentQuery::create()
        //     ->useCategoryQuery()
        //     ->filterByUrlkey('keynote')
        //     ->endUse()
        //     ->limit(3)
        //     ->find();
        // 
        // return array(
        //     'content' => $content,
        //     'last_lessons' => $last_lessons,
        // );
        return array();

    }

    /**
     * @Route("/category/{urlkey}", name="category_show")
     */
    public function categoryAction($urlkey)
    {
        $category = CategoryQuery::create()->filterByUrlkey($urlkey)->findOne();
        ;
        if (!$category) {
            throw $this->createNotFoundException('No category found for id '.$id);
        }

        $content = ContentQuery::create()->filterByCategoryId($category->getId())->limit(10)->orderByCreatedAt('desc')->find();

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
