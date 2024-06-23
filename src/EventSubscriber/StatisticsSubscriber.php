<?php

namespace App\EventSubscriber;

use Maximosojo\ToolsBundle\Component\EventDispatcher\GenericEvent;

/**
 * Escuchador de eventos de entidades
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class StatisticsSubscriber extends BaseSubscriber
{
    private $objectDataManager;

    public static function getSubscribedEvents(): array
    {
        $priority = 10;
        return [
            // ejemplo => AppEvents::APP_SECURITY_REGISTER_POST_SUCCESS => ['onUserPostRegister', $priority],
        ];
    }

    /**
     * Registra estadistica
     * @param GenericEvent $event
     */
    public function onUserPostRegister(GenericEvent $event)
    {
        $entity = $event->getEntity();
    }
}