<?php

namespace App\Model\Core\Notifier\Mailer;

use App\Traits\ORM\Basic\ExtraDataTrait;
use Doctrine\ORM\Mapping as ORM;
use Maximosojo\ToolsBundle\Model\Notifier\Mailer\ModelQueueInterface;

/**
 * Plantilla de correo
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
#[ORM\MappedSuperclass]
class ModelQueue implements ModelQueueInterface
{    
    /**
     * @var string
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'string', length: 255)]
    protected $subject;
    
    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'json')]
    protected $fromEmail;
    
    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'json')]
    protected $toEmail;
    
    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'text', nullable: true)]
    protected $body;
    
    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'string', length: 255)]
    protected $status;
    
    /**
     * @var string $environment
     *
     */
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    protected $environment;
    
    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'json')]
    protected $attachs;

    /**
     * @var \DateTime $sentAt
     *
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $createdAt;

    /**
     * @var \DateTime $sendAt
     */
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected $sendAt;

    /**
     * @var string
     *
     */
    #[ORM\Column(type: 'integer')]
    protected $retries = 0;

    use ExtraDataTrait;

    public function __construct()
    {
        $this->extraData = [];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    public function getToEmail()
    {
        return $this->toEmail;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getEnvironment()
    {
        return $this->environment;
    }

    public function getAttachs()
    {
        return $this->attachs;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    public function setToEmail(array $toEmail)
    {
        $this->toEmail = $toEmail;

        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    public function setEnvironment($environment)
    {
        $this->environment = $environment;

        return $this;
    }

    public function setAttachs($attachs)
    {
        $this->attachs = $attachs;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function onCreatedAt()
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

    public function getSendAt()
    {
        return $this->sendAt;
    }

    public function setSendAt(\DateTime $sendAt)
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    public function onSendAt()
    {
        $this->sendAt = new \DateTime();

        return $this;
    }

    public function onSendSuccessAt()
    {
        $this->onSendAt();
        $this->status = self::STATUS_COMPLETED;
        
        return $this;
    }

    public function onSendErrorAt()
    {
        $this->retries = $this->retries + 1;
        $this->status = self::STATUS_FAILED;
        
        return $this;
    }

    public function getRetries()
    {
        return $this->retries;
    }

    public function setRetries($retries)
    {
        $this->retries = $retries;

        return $this;
    }
}
