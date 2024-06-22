<?php

namespace App\Services\Core;

use App\Entity\M\Master\Term;
use App\Services\BaseService;

/**
 * Manejador de cuentas
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class CurrencyService extends BaseService
{
    public function findAll(): array
    {
        $currencies = $this->findByTermBy([
            "taxonomy" => Term::TAXONOMY_CURRENCY
        ]);

        return $currencies;
    }
}