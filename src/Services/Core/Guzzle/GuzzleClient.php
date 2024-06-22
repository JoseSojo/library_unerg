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

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\JsonResponse;
use Maximosojo\ToolsBundle\DependencyInjection\ContainerAwareTrait;

/**
 * Cliente Guzzle para BGPayment
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class GuzzleClient
{
    use ContainerAwareTrait;

    /**
     * Manejador de peticiones
     * @var AbstractHandler
     */
    protected $handler;

    private $initialize;

    protected function configureOptions(OptionsResolver $resolver)
    {
        $nativeHandler = new NativeHandler();
        $nativeHandler->setContainer($this->container);
        $resolver->setDefaults([
            "default_handler" => $nativeHandler,
            "form_params" => null,
        ]);
    }

    /**
     * Inicializa las opciones del servicio
     *
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     * @param   array  $options
     */
    public function initialize(array $options = [])
    {
        $this->initialize = true;
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'connect_timeout' => 10, //Tiempo de espera por establecer la conexion
            'timeout' => 25, //Tiempo de espera de respuesta
            "debug" => false, //Mostrar debug del client guzzle
            "exceptions" => false, //Lanzar excepcione
        ]);

        $resolver->setAllowedTypes("timeout", "integer");
        $resolver->setAllowedTypes("connect_timeout", "integer");
        $resolver->setAllowedTypes("debug", "bool");
        $resolver->setAllowedTypes("exceptions", "bool");
        $resolver->setRequired(["handler","default_handler"]);
        $this->configureOptions($resolver);

        $this->options = $resolver->resolve($options);

        $this->handler = $this->options["handler"];
        unset($this->options["handler"]);
        if($this->handler === null){
            $this->handler = $this->options["default_handler"];
        }
    }

    /**
     * Solicitud
     *
     * @author  Máximo Sojo <maxsojo13@gmail.com>
     * @param   $location
     * @param   array  $query
     *
     * @return  Response
     */
    public function request($location,array $query = [],array $options = [])
    {
        // Se inicializan las configuraciones por defecto
        if (!$this->initialize) {
            $options["handler"] = null;
            $this->initialize($options);
        }

        // Se resuelven las opciones
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'host' => null, // Host
            'headers' => [], // Cabecera
            'created_by' => null // Usuario que realiza la solicitud
        ]);

        $options = $resolver->resolve($options);
        // Se agrega al handle usuario que realiza la solicitud
        $this->handler->setHost($options["host"]);
        $this->handler->setHeaders($options["headers"]);
        $this->handler->setUser($options["created_by"]);

        $body = $this->handler->doRequest($location,$query);

        $response = $this->processResponse($body,$this->handler->getStatusCode());

        return $response;
    }

    /**
     * Procesar respuesta
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  $content
     * @param  $statusCode
     * @return JsonResponse
     */
    public function processResponse($content,$statusCode)
    {
        $response = JsonResponse::create($content, $statusCode);
        return $response;
    }
}
