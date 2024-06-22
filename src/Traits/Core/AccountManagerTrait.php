<?php

namespace App\Traits\Core;

use App\Services\User\AccountManager;

/**
 * Trait servicio de cuentas
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait AccountManagerTrait 
{
    protected $accountManager;

    /**
     * AccountManager
     *
     * @param   AccountManager  $accountManager
     *
     * @required
     */
    public function setAccountManager(AccountManager $accountManager)
    {
        $this->accountManager = $accountManager;
    }
}
