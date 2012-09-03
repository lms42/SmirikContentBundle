<?php

namespace Smirik\ContentBundle\Listener;

use Smirik\AdminBundle\Event\ConfigureMenuEvent;

class ConfigureMenuListener
{
    /**
     * @param \Smirik\AdminBundle\Event\ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $menu->addChild('admin.category.menu', array('route' => 'admin_categories_index'));
        $menu->addChild('admin.content.menu', array('route' => 'admin_content_index'));
    }
}