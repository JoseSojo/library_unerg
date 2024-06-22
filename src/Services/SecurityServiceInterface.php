<?php

namespace App\Services;

/**
 * Interfaz para seguridad
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
interface SecurityServiceInterface
{
    /**
     * Valida roles de usuario según rol asignado
     */
    public function isGranted($attributes, $subject = null);
}
