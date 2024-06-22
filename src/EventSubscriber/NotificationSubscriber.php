<?php

namespace App\EventSubscriber;

use App\AppEvents;
use App\Entity\M\User;
use FOS\UserBundle\FOSUserEvents;
use App\Entity\M\User\Notification;
use App\Services\Notification\NotificationManager;
use Maximosojo\ToolsBundle\Component\EventDispatcher\GenericEvent;

/**
 * Suscriptor de eventos para notificaciones
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class NotificationSubscriber extends BaseSubscriber
{
    private $notificationManager;

    public static function getSubscribedEvents(): array
    {
        $priority = 30;
        return [
            AppEvents::APP_SECURITY_REGISTER_PRE_SUCCESS => ['onUserGenericNotification', $priority],
            AppEvents::APP_SECURITY_REGISTER_CONFIRM_PRE_SUCCESS => ['onUserGenericNotification', $priority],
            AppEvents::APP_SECURITY_LOGIN_PRE_SUCCESS => ['onUserGenericNotification', $priority],
            AppEvents::APP_SECURITY_LOGIN_PRE_FAILED => ['onUserGenericNotification', $priority],
            AppEvents::APP_SECURITY_RESETTING_EMAIL_REQUEST_PRE_SUCCESS => ['onUserGenericNotification', $priority],
            AppEvents::APP_USER_PROFILE_UPDATE_PRE_SUCCESS => ['onUserGenericNotification', $priority],
            AppEvents::APP_USER_ADDRESS_UPDATE_PRE_SUCCESS => ['onUserGenericNotification', $priority],
            AppEvents::APP_USER_EMAIL_UPDATE_PRE_SUCCESS => ['onUserGenericNotification', $priority],
            AppEvents::APP_USER_PHONE_UPDATE_PRE_SUCCESS => ['onUserGenericNotification', $priority],
            AppEvents::APP_USER_PASSWORD_UPDATE_PRE_SUCCESS => ['onUserGenericNotification', $priority]
        ];
    }

    /**
     * Notifica
     * @param GenericEvent $event
     */
    public function onUserGenericNotification(GenericEvent $event, $nameEvent)
    {
        $entity = $event->getEntity();
        $options = [
            "title" => "label.notification.".$nameEvent,
            "content" => "label.notification.".$nameEvent.".content",
            "source" => $entity
        ];

        $this->notificationManager->send($entity,$options);
    }

    /**
     * setNotificationManager
     * 
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  NotificationManager $notificationManager
     */
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setNotificationManager(NotificationManager $notificationManager)
    {
        $this->notificationManager = $notificationManager;
    }
}
