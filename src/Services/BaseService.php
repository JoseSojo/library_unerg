<?php

namespace App\Services;

use App\Traits\Core\SecurityTrait;
use App\Traits\Core\TermTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Maximosojo\ToolsBundle\Service\DynamicBuilder\DynamicBuilderManager;
use Maximosojo\ToolsBundle\Traits\Component\EventDispatcherTrait;
use Maximosojo\ToolsBundle\Traits\Component\TranslatorTrait;
use App\Traits\DoctrineTrait;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Servicio base con implementación de funciones genericas compartidas
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class BaseService
{
    use EventDispatcherTrait;
    use TranslatorTrait;
    use DoctrineTrait;
    use SecurityTrait;
    use TermTrait;

    public function __construct(
            private \Symfony\Bundle\SecurityBundle\Security $security,
            private \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $tokenStorage,
            private \Symfony\Component\Routing\RouterInterface $router,
            private \Symfony\Component\Form\FormFactoryInterface $formFactory,
            protected \App\Services\User\UserManagerInterface $userManager
        )
    {
    }

    protected $requestStack;

    protected $geoIpService;

    protected $dynamicBuilderManager;

    /**
     * Logger
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;
    
    /**
     * Tipo error
     */
    const TYPE_DANGER = "error";
    
    /**
     * Tipo éxito
     */
    const TYPE_SUCCESS = "success";
    
    /**
     * Tipo alerta
     */
    const TYPE_WARNING = "warning";
    
    /**
     * Tipo información
     */
    const TYPE_INFO = "info";

    /**
     * Tipo depuración
     */
    const TYPE_DEBUG = "debug";

    /**
     * Creates and returns a Form instance from the type of the form.
     *
     * @param string $type    The fully qualified class name of the form type
     * @param mixed  $data    The initial data for the form
     * @param array  $options Options for the form
     *
     * @return \Symfony\Component\Form\FormInterface
     *
     * @final since version 3.4
     */
    protected function createForm($type, $data = null, array $options = array())
    {
        return $this->formFactory->create($type, $data, $options);
    }

    /**
     * DynamicBuilderManager
     *
     * @param   DynamicBuilderManager  $dynamicBuilderManager  [$dynamicBuilderManager description]
     */
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setDynamicBuilderManager(DynamicBuilderManager $dynamicBuilderManager)
    {
        $this->dynamicBuilderManager = $dynamicBuilderManager;
    }

    /**
     * Get a user from the Security Context
     * @return mixed
     * @throws LogicException If SecurityBundle is not available
     * @see TokenInterface::getUser()
     */
    public function getUser()
    {
        if (!$this->tokenStorage) {
            throw new \LogicException('The SecurityBundle is not registered in your application. Try running "composer require symfony/security-bundle".');
        }

        if (null === $token = $this->tokenStorage->getToken()) {
            return null;
        }

        return $token->getUser();
    }

    /**
     * Genera una url
     * @param type $route
     * @param array $parameters
     * @return type
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->router->generate($route, $parameters, $referenceType);
    }

    public function resolveClientIp()
    {
        $request = $this->requestStack->getCurrentRequest();
        $ip = $request->getClientIp();
        if ($request->server->has("HTTP_X_FORWARDED_FOR")) {
            $ip = $request->server->get('HTTP_X_FORWARDED_FOR');
        }

        return $ip;
    }

    public function resolveGeoIpData(string $ip)
    {
        $geoIpService = $this->geoIpService;

        $data = [
            "country" => [
                "id" => null,
                "name" => null
            ],
            "city" => [
                "id" => null,
                "name" => null
            ]
        ];

        try {
            $record = $geoIpService->getRecord($ip,"city");
            $data = [
                "country" => [
                    "id" => $record->country->isoCode,
                    "name" => $record->country->name
                ],
                "city" => [
                    "id" => null,
                    "name" => $record->city->name
                ]
            ];
        } catch (\GeoIp2\Exception\AddressNotFoundException $exc) {
            // $country = null;
        }

        return $data;
    }

    /**
     * setRequestStack
     * 
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  RequestStack $requestStack [description]
     */
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * GeoIpService
     * 
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  GeoIpService $geoIpService [description]
     */
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setGeoIpService(\Cravler\MaxMindGeoIpBundle\Service\GeoIpService $geoIpService)
    {
        $this->geoIpService = $geoIpService;
    }
}
