<?php

/*
 * This file is part of the GTI SOLUTIONS, C.A. - J409603954 package.
 * 
 * (c) www.gtisolutions.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Validator\Constraints;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Maximosojo\ToolsBundle\Component\Validator\ConstraintValidator as ConstraintValidatorBase;
use LogicException;
use Maximosojo\ToolsBundle\DependencyInjection\DoctrineTrait;
use Maximosojo\ToolsBundle\Traits\Component\EventDispatcherTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Base de validadores
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class ConstraintValidator extends ConstraintValidatorBase implements ContainerAwareInterface
{
    use DoctrineTrait;
    use EventDispatcherTrait;
    // public function __construct(private \Symfony\Component\Security\Core\Authentication\Token\Storage\UsageTrackingTokenStorage $usageTrackingTokenStorage, private \Symfony\Bundle\FrameworkBundle\Routing\Router $router)
    // {
    // }

    public function hasErrors()
    {
        return $this->context->getViolations()->count() > 0;
    }

    /**
     * Get a user from the Security Context
     * @return mixed
     * @throws LogicException If SecurityBundle is not available
     * @see TokenInterface::getUser()
     */
    public function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->usageTrackingTokenStorage->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            return;
        }

        return $user;
    }

    /**
     * Consulta de procesador
     * @author Máximo Sojo <maxsojo13@gmail.com>
     */
    public function getProcessor($processor)
    {
        $processor = $this->container->get($processor);
        $processor->setContainer($this->container);
        return $processor;
    }

    /**
     * Generates a URL from the given parameters.
     *
     * @param string $route         The name of the route
     * @param mixed  $parameters    An array of parameters
     * @param int    $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     *
     * @return string The generated URL
     *
     * @see UrlGeneratorInterface
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH) 
    {
        return $this->router->generate($route, $parameters, $referenceType);
    }
}
