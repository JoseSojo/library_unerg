<?php

namespace App\EventSubscriber;

use App\Entity\M\User;
use Gedmo\IpTraceable\IpTraceableListener;
use LogicException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Maximosojo\ToolsBundle\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * Listerner para establecer la ip al servicio
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class IpTraceSubscriber implements EventSubscriberInterface
{
    use ContainerAwareTrait;

    /**
     * @var IpTraceableListener
     */
    private $ipTraceableListener;

    private $requestStack;

    protected $logger;

    /**
     * Ip privada del cliente en el request
     * @var string
     */
    private $remoteIp;

    // public function __construct(IpTraceableListener $ipTraceableListener, LoggerInterface $logger, private \Symfony\Component\Security\Core\Authentication\Token\Storage\UsageTrackingTokenStorage $usageTrackingTokenStorage, private \Symfony\Bundle\FrameworkBundle\Routing\Router $router)
    // {
    //     $this->ipTraceableListener = $ipTraceableListener;
    //     $this->logger = $logger;
    // }

    public static function getSubscribedEvents(): array
    {
        return array(
            KernelEvents::REQUEST => 'onKernelRequest',
            SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin',
            KernelEvents::RESPONSE => 'onResponse'
        );
    }

    /**
     * Set the username from the security context by listening on core.request
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(RequestEvent $event)
    {
        // $request = $event->getRequest();
        // if (AppUtil::isCommandLineInterface()) {
        //     $this->ipTraceableListener->setIpValue("127.0.0.1");
        // }
        // if (null === $request) {
        //     return;
        // }

        // // If you use a cache like Varnish, you may want to set a proxy to Request::getClientIp() method 
        // // $request->setTrustedProxies(array('127.0.0.1'));
        // // $ip = $_SERVER['REMOTE_ADDR'];
        // $ip = $request->getClientIp();
        // if ($request->server->has("HTTP_X_FORWARDED_FOR")) {
        //     $ip = $request->server->get('HTTP_X_FORWARDED_FOR');
        // }

        // if (null !== $ip) {
        //     $this->ipTraceableListener->setIpValue($ip);
        // }

        // // $user = $this->getUser();
        // // if (!$request->isXmlHttpRequest() && $user) {
        // //     if ($user) {
        // //         if (strpos($request->getRequestUri(), "_switch_user=_exit") !== false) {
        // //             return;
        // //         }                
        // //     }
        // // }
    }

    /**
     * onInteractiveLogin
     *  
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  InteractiveLoginEvent $event 
     */
    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        $this->validateRecapcha($event);
    }

    public function validateRecapcha($event)
    {
        $force = false;
        if (($request = $event->getRequest()) != null) {
            if ($request->getPathInfo() === "/connect/google/check") {
                $force = true;
            }
        }
    }

    public function onResponse(ResponseEvent $event)
    {
        // $header = "_server";
        // if(is_array(($errorsResponse = $this->securityManager->getErrorsResponse())) && count($errorsResponse) > 0){
        //     $jsonServer = null;
        //     $server = $event->getResponse()->headers->get($header);
        //     if(is_string($server)  && is_array(($jsonServer = json_decode($server,true)))){

        //     }
        //     if(!is_array($jsonServer)){
        //         $jsonServer = [];
        //     }
        //     $jsonServer["errors"] = [];
        //     foreach ($errorsResponse as $code => $error) {
        //         $jsonServer["errors"][] = [
        //             "code" => $code,
        //             "message" => $error["message"],
        //             "extraData" => $error["extraData"]
        //         ];
        //     }

        //     $event->getResponse()->headers->set($header, json_encode($jsonServer));
        // }
    }

    /**
     * @return User
     * @throws LogicException
     */
    protected function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->usageTrackingTokenStorage->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }

        return $user;
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
     * Generates a URL from the given parameters.
     *
     * @param string $route         The name of the route
     * @param array  $parameters    An array of parameters
     * @param int    $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     *
     * @return string The generated URL
     *
     * @see UrlGeneratorInterface
     *
     * @final since version 3.4
     */
    protected function generateUrl($route, $parameters = [], $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->router->generate($route, $parameters, $referenceType);
    }
}
