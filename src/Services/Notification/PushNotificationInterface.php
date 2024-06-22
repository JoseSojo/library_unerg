<?php

namespace App\Services\Notification;

/**
 * Interfaz de servicio notificador push
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
interface PushNotificationInterface
{
    public function send(\App\Entity\M\User\Notification $notification,array $ids,$topics = null);
    
    public function getType();
    
}
