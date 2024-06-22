<?php

/*
 * This file is part of the Company Name Corporación C.A. - J123456789 package.
 * 
 * (c) www.companyname.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\M;

use App\Entity\M\Master\Term;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Model\User\ModelUser;

/**
 * Usuario de la sesion
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)
 */
#[ORM\Entity(repositoryClass: 'App\Repository\M\User\UserRepository')]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'users')]
class User extends ModelUser
{   
    /**
     * Identificación
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: true, length: 20)]
    private $identification;

    /**
     * Country
     * @var \App\Entity\M\Master\Term
     */
    #[ORM\ManyToOne(targetEntity: '\App\Entity\M\Master\Term')]
    #[ORM\JoinColumn(nullable: true)]
    private $country;

    /**
     * Ciudad
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    private $city;

    /**
     * Código postal
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    private $postalCode;

    /**
     * Exact address
     * @var string
     */
    #[ORM\Column(type: 'text', nullable: true)]
    private $address;

    /**
     * Numero
     * @var string
     */
    #[ORM\Column(type: 'string', length: 11, nullable: true)]
    private $phone;

    #[ORM\ManyToMany(targetEntity: 'App\Entity\M\Group')]
    #[ORM\JoinTable(name: 'users_group_user', joinColumns: [new ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')], inverseJoinColumns: [new ORM\JoinColumn(name: 'group_id', referencedColumnName: 'id')])]
    protected $groups;

    /**
     * Tipo
     * @var string
     */
    #[ORM\Column(type: 'string', length: 10)]
    private $type = self::TYPE_USER;

    /**
     * @var integer
     */
    #[ORM\Column(type: 'integer', nullable: true)]
    private $notificationsCount;

    /**
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    protected $avatar;

    /**
     * @var boolean
     */
    #[ORM\Column(type: 'boolean')]
    private $acceptedTerm = true;

    public function __construct()
    {
        parent::__construct();
        $this->timezone = 'America/Caracas';
    }

    public function getFullName()
    {
        if ($this->firstname && $this->lastname) {
            $fullname = sprintf("%s %s",$this->firstname,$this->lastname);
        } else {
            $fullname = $this->username;
        }

        return $fullname;
    }

    public function __toString()
    {
        $fullname = "";
        if ($this->firstname && $this->lastname) {
            $fullname = sprintf("%s %s",$this->firstname,$this->lastname);
        } else {
            $fullname = $this->username;
        }
        
        return $fullname;
    }

    public function onLastLogin()
    {
        $this->lastLogin = new \DateTime();
        
        return $this;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
        // Añade email como nombre de usuario
        if (is_null($email) == false) {
            $this->username = $email;    
        }
        
        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function prePersist(\Doctrine\ORM\Event\LifecycleEventArgs $event)
    {   
        $this->email = strtolower($this->email);
        $this->username = strtolower($this->username);
    }

    public function getIdentification(): ?string
    {
        return $this->identification;
    }

    public function setIdentification(?string $identification): static
    {
        $this->identification = $identification;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getNotificationsCount(): ?int
    {
        return $this->notificationsCount;
    }

    public function setNotificationsCount(?int $notificationsCount): static
    {
        $this->notificationsCount = $notificationsCount;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function isAcceptedTerm(): ?bool
    {
        return $this->acceptedTerm;
    }

    public function setAcceptedTerm(bool $acceptedTerm): static
    {
        $this->acceptedTerm = $acceptedTerm;

        return $this;
    }

    public function getCountry(): ?Term
    {
        return $this->country;
    }

    public function setCountry(?Term $country): static
    {
        $this->country = $country;

        return $this;
    }
}
