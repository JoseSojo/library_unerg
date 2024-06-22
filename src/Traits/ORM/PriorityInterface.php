<?php

namespace App\Traits\ORM;

/**
 * Interfaz de prioridad
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
interface PriorityInterface 
{
    /**
     * Baja
     */
    const PRIORITY_LOW = 100;

    /**
     * Media
     */
    const PRIORITY_MEDIUM = 200;

    /**
     * Alta
     */
    const PRIORITY_HIGH = 300;

    public function getPriority();
    
    public function setPriority($priority);
}
