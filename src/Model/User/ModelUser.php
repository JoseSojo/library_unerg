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
    const TYPE_COORDINADOR = "coordinador";
    const TYPE_AUTHOR = "author";

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