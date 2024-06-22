<?php

namespace App\Entity\M\User;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Model\User\ModelMobileDevice;
use App\Repository\M\User\MobileDeviceRepository;

/**
 * Dispositivo donde el usuario instalo la aplicacion
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
#[ORM\Entity(repositoryClass: MobileDeviceRepository::class)]
#[ORM\Table(name: 'users_mobile_devices')]
#[ORM\UniqueConstraint(name: 'device_idx', columns: ['type', 'device_id'])]
class MobileDevice extends ModelMobileDevice 
{
    /**
     * Tipo de dispositivo (self::TYPE_*)
     * @var integer
     */
    #[ORM\Column(type: 'string', length: 20)]
    private $type;
    
     /**
     * Identificador del dispositivo
     * @var string
     */
    #[ORM\Column(type: 'string', length: 255)]
    private $deviceId;
    
    /**
     * Version del sistema operativo
     * @var string
     */
    #[ORM\Column(type: 'string', length: 20)]
    private $osVersion;
    
    /**
     * Version de la app instalada
     * @var string
     */
    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private $appVersion;
    
    /**
     * Modelo del dispositivo
     * @var string
     */
    #[ORM\Column(type: 'string', length: 60)]
    private $model;
    
    /**
     * Informacion del dispositivo
     * @deprecated since version 1.0.6
     * @var string
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private $deviceInfo;
    
    /**
     * Identificador del registro
     * @var string
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private $registerId;
    
    /**
     * Data completa del registro para notificaciones push
     * @var string
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private $dataRegister;
    
    /**
     * @var \App\Entity\M\User
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\M\User', inversedBy: 'mobileDevices')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    public function __toString()
    {
        return $this->deviceId;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return MobileDevice
     */
    public function setType($type)
    {
        $this->type = self::parseOldType($type);

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set deviceId
     *
     * @param string $deviceId
     * @return MobileDevice
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Get deviceId
     *
     * @return string 
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set osVersion
     *
     * @param string $osVersion
     * @return MobileDevice
     */
    public function setOsVersion($osVersion)
    {
        $this->osVersion = $osVersion;

        return $this;
    }

    /**
     * Get osVersion
     *
     * @return string 
     */
    public function getOsVersion()
    {
        return $this->osVersion;
    }

    /**
     * Set model
     *
     * @param string $model
     * @return MobileDevice
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set deviceInfo
     *
     * @param string $deviceInfo
     * @return MobileDevice
     */
    public function setDeviceInfo($deviceInfo)
    {
        $this->deviceInfo = $deviceInfo;

        return $this;
    }

    /**
     * Get deviceInfo
     *
     * @return string 
     */
    public function getDeviceInfo()
    {
        return $this->deviceInfo;
    }

    /**
     * Set registerId
     *
     * @param string $registerId
     * @return MobileDevice
     */
    public function setRegisterId($registerId)
    {
        $this->registerId = $registerId;

        return $this;
    }

    /**
     * Get registerId
     *
     * @return string 
     */
    public function getRegisterId()
    {
        return $this->registerId;
    }

    /**
     * Set dataRegister
     *
     * @param string $dataRegister
     * @return MobileDevice
     */
    public function setDataRegister($dataRegister)
    {
        $this->dataRegister = $dataRegister;

        return $this;
    }

    /**
     * Get dataRegister
     *
     * @return string 
     */
    public function getDataRegister()
    {
        return $this->dataRegister;
    }

    /**
     * Set user
     *
     * @param \App\Entity\M\User $user
     * @return MobileDevice
     */
    public function setUser(\App\Entity\M\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Entity\M\User 
     */
    public function getUser()
    {
        return $this->user;
    }
    
    public function getAppVersion()
    {
        return $this->appVersion;
    }

    public function setAppVersion($appVersion)
    {
        $this->appVersion = $appVersion;
        return $this;
    }
    
    public function clearToken()
    {
        $this->registerId = null;
    }
}
