<?php

/*
 * This file is part of the Maxtoan Tools package.
 * 
 * (c) https://maxtoan.github.io/tools-bundle
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Traits\ORM;

use Doctrine\ORM\Mapping as ORM;

/**
 * Add Status behavior to an entity.
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait StatusTrait 
{
    /**
     * Status
     * @var string
     */
    #[ORM\Column(type: 'string')]
    private $status;    

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Type
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}