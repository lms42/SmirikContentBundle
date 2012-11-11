<?php

namespace Smirik\ContentBundle\Listener;

use Smirik\AdminBundle\Event\ConfigureMenuEvent;
use Smirik\ContentBundle\Model\CategoryQuery;

class ConfigureMenuListener
{
    /**
     * @param \Smirik\AdminBundle\Event\ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $menu->addChild('admin.content.menu');
        $menu['admin.content.menu']->addChild('admin.category.menu', array('route' => 'admin_categories_index'));
        $menu['admin.content.menu']->addChild('admin.content.menu', array('route' => 'admin_content_index'));
    }

    /**
     * @param \Smirik\AdminBundle\Event\ConfigureMenuEvent $event
     */
    public function onMainMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $categories = CategoryQuery::create()->filterByNavigation(true)->find();
        foreach ($categories as $category)
        {
            $menu->addChild($category->getTitle(), array('route' => 'category_show', 'routeParameters' => array('urlkey' => $category->getUrlkey())));
        }
    }

}