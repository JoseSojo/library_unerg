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

use Maximosojo\Bundle\BaseAdminBundle\Model\User\ModelGroup;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Grupo de roles para los usuarios
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
#[ORM\Entity(repositoryClass: 'App\Repository\M\User\GroupRepository')]
#[ORM\Table(name: 'users_group')]
class Group extends ModelGroup
{   
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    /**
     * Descripción del permiso
     * @var string
     */
    #[ORM\Column(type: 'string', nullable: true)]
    private $description;

    public function __toString() 
    {
        return $this->name?:"-";
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
