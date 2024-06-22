<?php


namespace App\Interfaces\Core;

/**
 * Interface para definir un entorno a un item
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
interface EnvironmentInterface
{
    /**
     * Modo: Desarrollo (Rol: ROLE_APP_ENV_DEVELOPMENT)
     */
    const ENV_DEVELOPMENT = "DEV";
    /**
     * Modo: Calidad (Rol: ROLE_APP_ENV_QUALITY)
     */
    const ENV_QUALITY = "QUA";
    /**
     * Modo: Productivo (Rol: No requiere rol)
     */
    const ENV_PRODUCTIVE = "PROD";
    
    public function getItemEnvironment();
    
    public function setItemEnvironment($itemEnvironment);
    
    public static function getAllEnvironments();
}
