<?php

namespace App\Traits\Core;

use App\Services\Core\CurrencyService;

/**
 * Trait servicio de monedas
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait CurrencyServiceTrait 
{
    protected $currencyService;

    /**
     * currencyService
     *
     * @param   CurrencyService  $currencyService
     *
     * @required
     */
    public function setCurrencyService(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }
}
