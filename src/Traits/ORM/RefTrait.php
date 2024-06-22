<?php

namespace App\Traits\ORM;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of RefTrait
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait RefTrait 
{    
    /**
     * Referencia de la transaccion
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private $ref;

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef($ref)
    {
        $this->ref = $ref;

        return $this;
    }
}