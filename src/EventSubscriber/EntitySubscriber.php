<?php

namespace App\EventSubscriber;

use App\AppEvents;
use Maximosojo\ToolsBundle\Component\EventDispatcher\GenericEvent;
use App\Entity\M\Event\Event;

/**
 * Escuchador de eventos de entidades
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class EntitySubscriber extends BaseSubscriber
{
    public static function getSubscribedEvents(): array
    {
        $priority = 100;

        return [
            AppEvents::APP_SECURITY_REGISTER_PRE_SUCCESS => ['onUserPreRegister', $priority],
        ];
    }

    /**
     * Notifica
     * @param GenericEvent $event
     */
    public function onUserPreRegister(GenericEvent $event, $nameEvent)
    {
        $entity = $event->getEntity();
        // $configuration = $this->configurationManager->get();
        // $entity->setLevelValidation($configuration->getDefaultLevelValidation());
        // Pre registra usuario
        $this->doPersist($entity,false);
        // Genera los requerimientos según el nivel actual
        // $this->requirementManager->generate($entity);
    }
}