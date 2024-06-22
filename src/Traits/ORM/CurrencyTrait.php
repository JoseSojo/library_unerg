<?php

/*
 * This file is part of the Maximosojo Tools package.
 * 
 * (c) https://maximosojo.github.io/tools-bundle
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Traits\ORM;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\M\Master\Term;

/**
 * CurrencyTrait
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait CurrencyTrait 
{   
    /**
     * Currency
     * @var \App\Entity\M\Master\Term
     */
    #[ORM\ManyToOne(targetEntity: '\App\Entity\M\Master\Term')]
    #[ORM\JoinColumn(nullable: true)]
    private $currency;

    public function getCurrency(): ?Term
    {
        return $this->currency;
    }

    public function setCurrency(?Term $currency): static
    {
        $this->currency = $currency;

        return $this;
    }
}