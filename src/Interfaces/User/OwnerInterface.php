<?php

namespace App\Interfaces\User;

/**
 * Interfaz que representa usuario dueño de objetos
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
interface OwnerInterface
{
    /**
     * @return \App\Entity\M\User usuario dueño del objeto
     */
    public function getUser();
}
