<?php

namespace App\EventSubscriber;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Maximosojo\ToolsBundle\Component\EventDispatcher\GenericEvent;
use FOS\UserBundle\FOSUserEvents;
use App\AppEvents;
use App\EventSubscriber\BaseSubscriber;
use Maximosojo\ToolsBundle\Service\Notifier\MailerManager;

/**
 * Suscriptor de eventos para enviar correos
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class EmailSubscriber extends BaseSubscriber
{
    private $mailerManager;

    public static function getSubscribedEvents(): array
    {
        $priority = 20;
        return [
            AppEvents::APP_SECURITY_REGISTER_PRE_SUCCESS => ['onUserPreRegister', $priority],
            // AppEvents::APP_SECURITY_LOGIN_PRE_SUCCESS => ['onUserLoginSuccess', $priority],
            AppEvents::APP_SECURITY_RESETTING_EMAIL_REQUEST_PRE_SUCCESS => ['onUserResettingEmailPreRequest', $priority],
        ];
    }

    /**
     * Envia correo al registrar
     * @param GenericEvent $event
     */
    public function onUserPreRegister(GenericEvent $event)
    {
        $entity = $event->getEntity();
        $context = array();
        $context["entity"] = $entity;
        $this->mailerManager->onEmailQueue("security_register_1", $entity->getEmail(), $context);
    }

    /**
     * Envia correo al iniciar sesion
     * @param GenericEvent $event
     */
    public function onUserLoginSuccess(GenericEvent $event)
    {
        $entity = $event->getEntity();
        $context = array();
        $context["entity"] = $entity;
        $this->mailerManager->onEmailQueue("security_login_success_1", $entity->getEmail(), $context);
    }

    /**
     * Envia correo al iniciar sesion
     * @param GenericEvent $event
     */
    public function onUserResettingEmailPreRequest(GenericEvent $event)
    {
        $entity = $event->getEntity();
        $context = array();
        $context["entity"] = $entity;
        $this->mailerManager->onEmailQueue("security_resetting_1", $entity->getEmail(), $context);
    }

    /**
     * Servicio para enviar email
     * @return \Maximosojo\ToolsBundle\Service\Notifier\MailerManager
     * @required
     */
    public function setMailerManager(MailerManager $mailerManager)
    {
        $this->mailerManager = $mailerManager;   
    }  
}