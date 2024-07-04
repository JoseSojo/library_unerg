<?php

namespace App\Traits\ORM;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\M\User;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Description of UserTrait
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait UserTrait 
{    
    /**
     * 
     * @var \App\Entity\M\User
     */
    #[ORM\ManyToOne(targetEntity: 'App\Entity\M\User')]
    #[ORM\JoinColumn(nullable: false)]
    protected $user;

    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }


    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    
    public function isOwner(UserInterface $user)
    {
        return $this->user === $user;
    }
}