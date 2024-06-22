<?php

namespace App\Services\User\Security;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\M\Master\User\Security\Method;

/**
 * Interfas de procesadores de seguridad
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
interface SecurityProcessorInterface
{
    /**
     * Valida un método
     */
    public function update(Request $request, Method $method);

    // public static function getName();

    // public function getClass();
}
