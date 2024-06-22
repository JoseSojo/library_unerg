<?php 

/*
 * This file is part of the Company Name Corporación C.A. - J123456789 package.
 * 
 * (c) www.companyname.com
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Maximosojo\ToolsBundle\Model\Paginator\Paginator;
use Maximosojo\ToolsBundle\Component\FOS\RestBundle\View\FOSRestViewTrait;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\M\User;
use ReflectionClass;
use App\Interfaces\Core\EnvironmentInterface;
use Maximosojo\ToolsBundle\Controller\AbstractFOSRestController;

/**
 * Controlador base
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class Controller extends AbstractFOSRestController
{
    use FOSRestViewTrait;

    public const ICON_EDIT = "edit";
    public const ICON_ACCOUNT_CIRCLE = "account_circle";
    public const ICON_ACTION = "arrow_forward_ios";
    public const ICON_EXIT_TO_APP = "exit_to_app";
    public const ICON_POWER_OFF = "power_off";
    public const ICON_ADD_A_PHOTO = "add_a_photo";
    public const ICON_ADD_COMMENT = "add_comment";
    public const ICON_ADD_LOCATION = "add_location";
    public const ICON_ADD_LOCATION_ALT = "add_location_alt";
    public const ICON_SEARCH = "search";
    public const ICON_BOOKMARK = "bookmark";
    public const ICON_BOOKMARK_REMOVE = "bookmark_remove";
    public const ICON_DIRECTIONS = "directions_rounded";
    public const ICON_CHAT = "chat";
    public const ICON_SHARE = "share";
    public const ICON_LOCK = "lock";
    
    /**
     * setTitle
     * @author Máximo Sojo maxsojo13@gmail.com <maxtoan>
     * @param  array $title
     * @param  array $icon
     */
    public function setTitle($title = "")
    {
        $this->getRequest()->request->set('title', $this->trans($title,[],"titles"));
    }

    /**
     * Registro de mensaje flash
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  String
     * @param  String
     */
    public function setFlash($type, $message = "", $parameters = [])
    {
        $this->addFlash($type,$this->trans($message,$parameters,'flashes'));
    }
    
    /**
     * getRequest
     * @author Máximo Sojo maxsojo13@gmail.com <maxtoan>
     * @return $request
     */
    private function getRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }

    /**
     * Genera url para formato json
     *  
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  [type] $url        [description]
     * @param  array  $parameters [description]
     * @return [type]             [description]
     * @deprecated
     */
    public function generateUrlJson($url, $parameters = [])
    {
        $parameters = array_merge($parameters, ["_format" => "json"]);
        return $this->generateUrl($url, $parameters);
    }

    protected function buildData(Request $request,Paginator $paginator,$toStringCallback = null)
    {
        $page = (int)$request->get("page");
        if($page <= 0){
            $page = 1;
        }
        $paginator->setCurrentPage($page);
        
        $data = [
            "results" => [],
            "more" => $paginator->hasNextPage(),
            "nb_results" => $paginator->getNbResults(),
        ];
        $results = $paginator->getCurrentPageResults();
        foreach ($results as $result) {
            $item = [
                "id" => $result->getId(),
            ];
            $item["text"] = $toStringCallback === null ? (string)$result : $toStringCallback($result);
            $data["results"][] = $item;
        }
        return $data;
    }

    /**
     * Verifica si el recurso puede ser usado
     * @param $object
     * @return boolean
     */
    protected function denyIsNotResource($object,$throw = true)
    {
        $isResource = true;
        // Valida el entorno
        $reflectionClass = new ReflectionClass($object);
        if ($reflectionClass->hasMethod("getItemEnvironment")) {
            //Por defecto se permiten los que estan en productivo
            $envsAllowed = [
                EnvironmentInterface::ENV_PRODUCTIVE,
            ];
            if ($this->isGranted("ROLE_APP_ENV_DEVELOPMENT")) {
                $envsAllowed[] = EnvironmentInterface::ENV_DEVELOPMENT;
            }
            if ($this->isGranted("ROLE_APP_ENV_QUALITY")) {
                $envsAllowed[] = EnvironmentInterface::ENV_QUALITY;
            }
            if (!in_array($object->getItemEnvironment(),$envsAllowed)) {
                $isResource = false;
            }
        }

        if ($reflectionClass->hasMethod("getEnabled")) {
            if ($object->isEnabled() === false) {
                $isResource = false;
            }
        }

        if($throw === true && $isResource === false){
            throw $this->createAccessDeniedException("El recurso no esta disponible, intente de nuevo mas tarde.");
        }

        return $isResource;
    }

    /**
     * Verifica si es el usuario logueado es dueño del objeto, sino niega el acceso
     * @param \App\Interfaces\User\OwnerInterface $object
     * @return boolean
     */
    protected function denyIsNotOwner(\App\Interfaces\User\OwnerInterface $object,$throw = true)
    {
        $currentUser = $this->getUser();
        $isOwner = false;
        if($currentUser === $object->getUser()){
            $isOwner = true;
        }

        if($throw === true && $isOwner === false){
            throw $this->createAccessDeniedException("No tiene permiso para realizar esta operación.");
        }

        return $isOwner;
    }
}