<?php

namespace App\Traits\Core;

use App\Services\SecurityService;

/**
 * Trait servicio de monedas
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait SecurityServiceTrait 
{
    protected $securityService;

    /**
     * securityService
     *
     * @param   SecurityService  $securityService
     *
     * @required
     */
    public function setSecurityService(SecurityService $securityService)
    {
        $this->securityService = $securityService;
    }
}
