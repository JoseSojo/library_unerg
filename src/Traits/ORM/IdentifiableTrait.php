<?php

namespace App\Traits\ORM;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * IdentifiableTrait
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait IdentifiableTrait 
{   
    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'string', length: 36)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    protected $id;
    
    /**
     * Get Id
     * @return Uuid
     */
    public function getId()
    {
        return $this->id;
    }
}
