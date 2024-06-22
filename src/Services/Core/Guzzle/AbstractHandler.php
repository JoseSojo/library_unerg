<?php

/*
 * This file is part of the Company Name Corporación C.A. - J123456789 package.
 *
 * (c) www.companyname.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace App\Services\Core\Guzzle;

use App\Entity\M\User;

/**
 * Base de manejador de peticiones
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class AbstractHandler
{
    /**
     * Estatus http: Error estableciendo conexion con el cliente
     */
    const STATUS_CONNECTION_TIMEOUT = 504;
    /**
     * Estatus http: El cliente tardo mucho en responder la peticion
     */
    const STATUS_REQUEST_TIMEOUT = 408;
    /**
     * Estatus http: Error de validacion
     */
    const STATUS_REQUEST_ERROR = 400;
    /**
     * Estaus: Todo bien
     */
    const STATUS_OK = 200;

    /**
     * Opciones de peticion
     * @var array
     */
    protected $options;

    /**
     * Uri del servicio a llamar
     * @var string
     */
    protected $location;

    /**
     * Base de url
     * @var String
     */
    protected $host;

    /**
     * Cabecera
     * @var array
     */
    protected $headers;

    /**
     * Container
     * @var String
     */
    protected $container;

    /**
     * Codigo de estatus
     * @var integer
     */
    protected $statusCode;

    /**
     * Respuesta de la peticion
     * @var Response
     */
    protected $lastResponse;

    /**
     * Entorno
     * @var String
     */
    protected $env;

    protected $user;

    public function doInitialize(){}

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setHeaders(array $headers = array())
    {
        $this->headers = $headers;
    }

    /**
     * Contenedor
     *
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     * @param   $container
     */
    public function setContainer($container)
    {
        $this->container = $container;
    }

    /**
     * Codigo de respuesta de la ultima peticion
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setUser(User $user = null)
    {
        $this->user = $user;
        return $this;
    }
}
