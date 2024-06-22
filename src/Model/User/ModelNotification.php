<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\User;

use App\Model\Base\ModelBase;

/**
 * Modelo de notificacion
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class ModelNotification extends ModelBase
{    
    /**
     * Estatus de las Notificaciones
     */
    public const STATUS_UNREAD = "unread";
    public const STATUS_READ = "read";

    /**
     * Estatus de envío
     */
    public const SEND_STATUS_NEW = "new";
    public const SEND_STATUS_SEND = "send";
    public const SEND_STATUS_ERROR = "error";
    public const SEND_STATUS_FAIL = "fail";

    /**
     * Extra
     */
    public const EXTRA_ERROR_FIELD = "error";
    public const EXTRA_MESSAGE = "message";
    
    /**
     * Origen de notificacion
     */
    public const SOURCE_USER = "user";
    public const SOURCE_RECHARGE = "recharge";
    public const SOURCE_WITHDRAW = "withdraw";
    public const SOURCE_PAYMENT = "payment";

    public function isObjectType($type)
    {
        return $type === $this->getSourceTypeObject();
    }

    public function isStatus($status)
    {
        return $status === $this->getStatus();
    }

    public function isUnread()
    {
        return $this->isStatus(self::STATUS_UNREAD);
    }

    static function getLabelsStatus() 
    {
        return array(
            "label.notification.status.read" => self::STATUS_READ,
            "label.notification.status.un_read" => self::STATUS_UNREAD
        );
    }

    public function getStatusLabel()
    {
        $statusLabels = self::getLabelsStatus();
        return $statusLabels === null ? : array_search($this->getStatus(),$statusLabels);
    }
}