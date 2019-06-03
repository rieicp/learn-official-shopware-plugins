<?php

namespace SwagStartup\Subscribers;

use Enlight\Event\SubscriberInterface;

class RoutingSubscriber implements SubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PreDispatch' => 'onPreDispatch'
        ];
    }

    public function onPreDispatch(\Enlight_Event_EventArgs $args)
    {
//        die('abc');
        $controller = $args->getSubject();
        $controller->View()->addTemplateDir(__DIR__ . '/../Resources/views');
    }
}
