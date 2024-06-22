<?php

namespace App\Services;

use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Servicio para control de seguridad
 * Usado para controlar el acceso a las funciones de seguridad
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class SecurityService implements SecurityServiceInterface
{
    protected $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * Checks if the attributes are granted against the current authentication token and optionally supplied subject.
     *
     * @param mixed $attributes The attributes
     * @param mixed $subject    The subject
     *
     * @return bool
     *
     * @throws \LogicException
     */
    public function isGranted($attributes, $subject = null) 
    {
        if (!$this->authorizationChecker) {
            throw new \LogicException('The SecurityBundle is not registered in your application. Try running "composer require symfony/security-bundle".');
        }

        return $this->authorizationChecker->isGranted($attributes, $subject);
    }
}