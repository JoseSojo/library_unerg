<?php

namespace App\Entity\M\User;

use Doctrine\ORM\Mapping as ORM;
use App\Model\User\ModelNotification;
use App\Traits\ORM\Basic\ExtraDataTrait;

/**
 * Notificacion
 *
 * @author Carlos Mendoza <inhack20@gmail.com>
 */
#[ORM\Entity(repositoryClass: 'App\Repository\M\User\NotificationRepository')]
#[ORM\Table(name: 'users_notifications')]
class Notification extends ModelNotification
{
     /**
     * @var string
     */
    #[ORM\Column(name: 'title', type: 'string', length: 255, nullable: false)]
    private $title;

    /**
     * @var string
     */
    #[ORM\Column(name: 'content', type: 'string', length: 255, nullable: true)]
    private $content;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'status', type: 'string', length: 20, nullable: false)]
    private $status = self::STATUS_UNREAD;
    
    /**
     * @var \App\Entity\M\User
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\M\User')]
    #[ORM\JoinColumn(nullable: true)]
    private $user;
    
    /**
     * @var string
     */
    #[ORM\Column(name: 'send_status', length: 10, type: 'string', nullable: true)]
    private $sendStatus = self::SEND_STATUS_NEW;
    
    /**
     * Tipo de objeto que genero la notificacion
     * @var integer
     */
    #[ORM\Column(name: 'source_type_object_id', type: 'string', length: 36, nullable: false)]
    private $sourceTypeObjectId;
    
    /**
     * Tipo de objeto que genero la notificacion
     * @var integer
     */
    #[ORM\Column(name: 'source_type_object', type: 'string', length: 30, nullable: false)]
    private $sourceTypeObject;
    
    /**
     * Campo volatil para colocar la enviar 
     * @var type
     */
    private $sound;

    use ExtraDataTrait;

    public function __construct()
    {
        $this->extraData = [];
    }

    public static function getSourceObjects()
    {
        return [
            self::SOURCE_PAYMENT => 'App\Entity\M\User\TransactionItem\Payment',
            self::SOURCE_WITHDRAW => 'App\Entity\M\User\TransactionItem\Withdraw',
            self::SOURCE_RECHARGE => 'App\Entity\M\User\TransactionItem\Recharge',
            self::SOURCE_USER => 'App\Entity\M\User'
        ];
    }
    
    /**
     * Establece la fuente de la notificacion
     * @param \App\Model\Base\ModelBaseInterface $item
     * @throws \LogicException
     */
    public function setSource(\App\Model\Base\ModelBaseInterface $item)
    {
        $sourceObjects = $this->getSourceObjects();
        $className = \Doctrine\Common\Util\ClassUtils::getRealClass(get_class($item));
        $sourceType = array_search($className, $sourceObjects);
        if(!isset($sourceObjects[$sourceType])){
//            throw new \LogicException(sprintf("La clase '%s' no esta configurada para ser usada en una notificacion",$className));
        }

        $this->setSourceTypeObject($sourceType);
        $this->setSourceTypeObjectId($item->getId());

        // Añade valores pago tipos y monto
        if($item instanceof \App\Entity\M\User\TransactionItem\Payment){
            $this->setExtraData("type", $item->getType());
            $this->setExtraData("amount", $item->getAmountTotal());
        }
    }
    
    public function getTitle()
    {
        return $this->title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getUser(): \App\Entity\M\User
    {
        return $this->user;
    }

    public function getSendStatus()
    {
        return $this->sendStatus;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function setUser(\App\Entity\M\User $user)
    {
        $this->user = $user;
        return $this;
    }

    public function setSendStatus($sendStatus)
    {
        $this->sendStatus = $sendStatus;
        return $this;
    }
    
    public function getSourceTypeObjectId()
    {
        return $this->sourceTypeObjectId;
    }

    public function getSourceTypeObject()
    {
        return $this->sourceTypeObject;
    }

    public function setSourceTypeObjectId($sourceTypeObjectId)
    {
        $this->sourceTypeObjectId = $sourceTypeObjectId;
        return $this;
    }

    public function setSourceTypeObject($sourceTypeObject)
    {
        $this->sourceTypeObject = $sourceTypeObject;
        return $this;
    }
}