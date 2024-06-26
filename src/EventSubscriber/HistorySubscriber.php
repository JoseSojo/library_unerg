<?php

namespace App\EventSubscriber;

use App\AppEvents;
use Maximosojo\ToolsBundle\Component\EventDispatcher\GenericEvent;
use Maximosojo\ToolsBundle\Service\ObjectManager\ObjectDataManagerInterface;
use Maximosojo\ToolsBundle\Model\ObjectManager\HistoryManager\DoctrineORM\ModelHistory;
use Symfony\Component\Security\Http\Event\SwitchUserEvent;
use Symfony\Component\Security\Http\SecurityEvents;
// use App\Entity\M\Business\Business;
use App\Entity\M\User;
use App\Entity\M\User\Bookmark;

/**
 * Escuchador de eventos de entidades
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class HistorySubscriber extends BaseSubscriber
{
    private $objectDataManager;

    public static function getSubscribedEvents(): array
    {
        $priority = 10;
        return [
            AppEvents::APP_SECURITY_LOGIN_PRE_SUCCESS => ['onDefaultHistory', $priority],
            AppEvents::APP_SECURITY_LOGIN_PRE_FAILED => ['onDefaultHistory', $priority],
            AppEvents::APP_SECURITY_RESETTING_EMAIL_REQUEST_POST_SUCCESS => ['onDefaultHistory', $priority],
            AppEvents::APP_USER_PROFILE_UPDATE_POST_SUCCESS => ['onDefaultHistory', $priority],
            AppEvents::APP_USER_ADDRESS_UPDATE_POST_SUCCESS => ['onDefaultHistory', $priority],
            AppEvents::APP_USER_EMAIL_UPDATE_POST_SUCCESS => ['onDefaultHistory', $priority],
            AppEvents::APP_USER_PHONE_UPDATE_POST_SUCCESS => ['onDefaultHistory', $priority],
            AppEvents::APP_USER_PASSWORD_UPDATE_POST_SUCCESS => ['onDefaultHistory', $priority],
        ];
    }

    /**
     * Registra historial
     * @param GenericEvent $event
     */
    public function onDefaultHistory(GenericEvent $event, $nameEvent)
    {
        $user = null;
        $entity = $event->getEntity();
        if ($entity instanceof User) {
            $user = $entity;
        } 

        if (is_null($user)) {
            return;
        }

        $historyManager = $this->objectDataManager->histories();
        $historyManager->configure($entity->getId(),User::OBJECT_DATA_MANAGER);

        $array = [
            "eventName" => $nameEvent,
            "type" => ModelHistory::TYPE_WARNING,
            "user" => $user,
            "description" => "title.history.".$nameEvent
        ];
        $historyManager->create($array);
    }
}