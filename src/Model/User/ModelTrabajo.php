<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Model\User;

use App\Model\Base\ModelBase;

/**
 * Modelo de listas
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class ModelTrabajo extends ModelBase
{
    /**
     * Object Data
     */
    public const OBJECT_DATA_MANAGER = "Trabajo";

    // Status
    public const STATUS_APROVADO = "aprovado";
    public const STATUS_IN_PROGRESS = "en espera";

    // Object types

    // Source Objects
}