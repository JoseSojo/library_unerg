<?php

namespace App;

use Symfony\Component\HttpFoundation\Response;

/**
 * Clase donde se migraran los CHAIN y se iran colocando los LOCK de los diferentes formularios
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
final class AppGlobal 
{
    public const LOCK_STATUS_CODE = Response::HTTP_LOCKED;
    
    /**
     * Constantes de comandos
     */
    public const LOCK_COMMAND_CRON = "lock_command_cron";

    /**
     * Constantes de operaciones
     */
    public const LOCK_TRANSACTION_CREATE = "lock_transaction_create";
    public const LOCK_TRANSACTION_CONFIRM = "lock_transaction_confirm";

    // Chains
    public const CHAIN_USER = "user";
    public const CHAIN_EVENT = "event";

    /**
     * Formularios de busqueda
     *
     * @return  Array
     */
	public static function getSearchForm()
    {
        $array = [
            self::CHAIN_USER => \App\Form\Core\Search\User\UserType::class,
            self::CHAIN_EVENT => \App\Form\Core\Search\Event\EventType::class,
        ];

        return $array;
    }
}