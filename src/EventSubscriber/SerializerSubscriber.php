<?php

namespace App\EventSubscriber;

use JMS\Serializer\EventDispatcher\Events;
use JMS\Serializer\EventDispatcher\ObjectEvent;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;

/**
 * Listener de serializacion para agregar data extra al serializar
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class SerializerSubscriber implements EventSubscriberInterface
{
    use \Maximosojo\ToolsBundle\DependencyInjection\ContainerAwareTrait;

    public static function getSubscribedEvents()
    {
        return array(
            
        );
    }
}
