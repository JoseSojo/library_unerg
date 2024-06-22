<?php

namespace App\Model\User;

use Maximosojo\Bundle\BaseAdminBundle\Model\User\ModelUser as BaseUser;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Maxtoan\Common\Util\MathUtil;
use App\Traits\ORM\TimestampableTrait;
use App\Traits\ORM\SoftDeleteableTrait;
use App\Traits\ORM\BlameableTrait;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use App\Model\Base\ModelBaseInterface;

/**
 * Modelo de usuario
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class ModelUser extends BaseUser implements ModelBaseInterface
{
    /**
     * Tipos de usuarios
     */
    const TYPE_ADMIN = "admin";
    const TYPE_AUTHOR = "author";
    const TYPE_USER = "user";

	#[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string', length: 36)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected $id;

    protected $currentPassword;

    protected $plainPasswordFirst;

    protected $plainPasswordSecond;
    
	use TimestampableTrait;
    use SoftDeleteableTrait;
    use BlameableTrait;

    /**
     * Get Id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function isStatus($status)
    {
        return $this->getStatus() === $status;
    }

    public function getStatusArray()
    {
        $array = [
            "label.status.user.not_validated" => self::STATUS_NOT_VALIDATED,
            "label.status.user.invalidated" => self::STATUS_INVALIDATED,
            "label.status.user.validated" => self::STATUS_VALIDATED,
            "label.status.user.pending" => self::STATUS_PENDING
        ];

        return $array;
    }

    public function getStatusArrayValidated()
    {
        $array = [
            "label.status.user.invalidated" => self::STATUS_INVALIDATED,
            "label.status.user.validated" => self::STATUS_VALIDATED
        ];

        return $array;
    }

    public function getColorsArray()
    {
        $array = [
            sprintf("warning %s",self::STATUS_NOT_VALIDATED) => self::STATUS_NOT_VALIDATED,
            sprintf("success %s",self::STATUS_VALIDATED) => self::STATUS_VALIDATED,
            sprintf("danger %s",self::STATUS_INVALIDATED) => self::STATUS_INVALIDATED,
            sprintf("info %s",self::STATUS_PENDING) => self::STATUS_PENDING
        ];

        return $array;
    }

    public function getStatusColor()
    {
        $colorArray = self::getColorsArray();
        return $colorArray === null ? : array_search($this->getStatus(),$colorArray);
    }

    public function getStatusLabel()
    {
        $statusArray = self::getStatusArray();
        return $statusArray === null ? : array_search($this->getStatus(),$statusArray);
    }

    public function getAge()
    {
        $age = 0;
        if ($this->birthday) {
            $now = new \DateTime();
            $age = $now->diff($this->birthday);
            $age = $age->y;
        }

        return $age;
    }

    /**
     * ¿El usuario es tipo?
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  Type
     * @return boolean
     */
    public function isType($type)
    {
        return $this->getType() === $type;
    }

    public function setCurrentPassword($currentPassword)
    {
        $this->currentPassword = $currentPassword;
        return $this;
    }

    public function getCurrentPassword()
    {
        return $this->currentPassword;
    }

    public function setPlainPasswordFirst($plainPasswordFirst)
    {
        $this->plainPasswordFirst = $plainPasswordFirst;
        return $this;
    }

    public function getPlainPasswordFirst()
    {
        return $this->plainPasswordFirst;
    }

    public function setPlainPasswordSecond($plainPasswordSecond)
    {
        $this->plainPasswordSecond = $plainPasswordSecond;
        return $this;
    }

    public function getPlainPasswordSecond()
    {
        return $this->plainPasswordSecond;
    }
}