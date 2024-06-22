<?php

namespace App\EventListener;

use Maximosojo\ToolsBundle\Traits\Component\EventDispatcherTrait;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use League\Bundle\OAuth2ServerBundle\Event\UserResolveEvent;
use App\AppEvents;

final class UserResolveListener
{
    use EventDispatcherTrait;

    /**
     * @var UserProviderInterface
     */
    private $userProvider;

    /**
     * @var UserPasswordHasherInterface
     */
    private $userPasswordHasher;

    public function __construct(UserProviderInterface $userProvider, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userProvider = $userProvider;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function onUserResolve(UserResolveEvent $event): void
    {
        try {
            $user = $this->userProvider->loadUserByIdentifier($event->getUsername());
        } catch (AuthenticationException $e) {
            return;
        }

        if (null === $user || !($user instanceof PasswordAuthenticatedUserInterface)) {
            return;
        }

        if ($user->isLocked() === true) {
            return;
        }

        if ($user->isEnabled() === false) {
            return;
        }

        if (!$this->userPasswordHasher->isPasswordValid($user, $event->getPassword())) {
            $this->dispatch(AppEvents::APP_SECURITY_LOGIN_PRE_FAILED,$this->newGenericEvent($user));
            return;
        }

        $user->onLastLogin();
        $event->setUser($user);
        $this->dispatch(AppEvents::APP_SECURITY_LOGIN_PRE_SUCCESS,$this->newGenericEvent($user));
    }
}