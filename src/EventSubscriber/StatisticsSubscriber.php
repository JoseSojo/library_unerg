<?php

namespace App\EventSubscriber;

use App\AppEvents;
use Maximosojo\ToolsBundle\Component\EventDispatcher\GenericEvent;
use Maximosojo\ToolsBundle\Service\ObjectManager\ObjectDataManagerInterface;
use App\Entity\M\User;
use App\Entity\M\User\Bookmark;
// use App\Entity\M\Business\Business;
use Maxtoan\Common\Util\MathUtil;

/**
 * Escuchador de eventos de entidades
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class StatisticsSubscriber extends BaseSubscriber
{
    private $objectDataManager;

    public static function getSubscribedEvents(): array
    {
        $priority = 10;
        return [
            // AppEvents::APP_SECURITY_REGISTER_POST_SUCCESS => ['onUserPostRegister', $priority],
            // AppEvents::APP_BUSINESS_SHOW_POST_SUCCESS => ['onBusinessPostShow', $priority],
            // AppEvents::APP_BUSINESS_CREATE_POST_SUCCESS => ['onBusinessPostCreate', $priority],
            // AppEvents::APP_USER_BOOKMARK_CREATE_POST_SUCCESS => ['onBookmarkPostCreate', $priority],
        ];
    }

    /**
     * Registra estadistica
     * @param GenericEvent $event
     */
    public function onUserPostRegister(GenericEvent $event)
    {
        $entity = $event->getEntity();
        $country = $entity->getCountry();
        $statisticManager = $this->objectDataManager->statistics();
        $statisticManager->configure($country->getId(),Country::OBJECT_DATA_MANAGER);
        $statisticManager->setObject(Country::OBJECT_DATA_USER_REGISTER);
        $statisticManager->countStatisticsMonth();
    }

    /**
     * Registra estadistica
     * @param GenericEvent $event
     */
    public function onBusinessPostShow(GenericEvent $event)
    {
        $entity = $event->getEntity();
        $user = $entity->getUser();
        $statisticManager = $this->objectDataManager->statistics();
        // Registra estadisticas de pais
        $statisticManager->configure($entity->getId(),Business::OBJECT_DATA_MANAGER);
        $statisticManager->setObject(Business::OBJECT_DATA_USER_SHOW);
        $statisticManager->countStatisticsMonth();
        // Registra estadisticas de usuario
        $statisticManager->configure($user->getId(),User::OBJECT_DATA_MANAGER);
        $statisticManager->setObject(User::OBJECT_DATA_BUSINESS_SHOW);
        $statisticManager->countStatisticsMonth();
    }

    /**
     * Registra estadistica
     * @param GenericEvent $event
     */
    public function onBusinessPostCreate(GenericEvent $event)
    {
        $entity = $event->getEntity();
        $user = $entity->getUser();
        $country = $user->getCountry();
        $statisticManager = $this->objectDataManager->statistics();
        // Registra estadisticas de pais
        $statisticManager->configure($country->getId(),Country::OBJECT_DATA_MANAGER);
        $statisticManager->setObject(Country::OBJECT_DATA_BUSINESS_REGISTER);
        $statisticManager->countStatisticsMonth();
        // Registra estadisticas de usuario
        $statisticManager->configure($user->getId(),User::OBJECT_DATA_MANAGER);
        $statisticManager->setObject(User::OBJECT_DATA_BUSINESS_REGISTER);
        $statisticManager->countStatisticsMonth();
    }

    /**
     * Registra estadistica
     * @param GenericEvent $event
     */
    public function onBookmarkPostCreate(GenericEvent $event)
    {
        $entity = $event->getEntity();
        $business = $entity->getBusiness();
        $user = $entity->getUser();
        
        $statisticManager = $this->objectDataManager->statistics();
        // Registra estadisticas de pais
        $statisticManager->configure($business->getId(),Business::OBJECT_DATA_MANAGER);
        $statisticManager->setObject(Business::OBJECT_DATA_BOOKMARK_REGISTER);
        $statisticManager->countStatisticsMonth();
        // Registra estadisticas de usuario
        $statisticManager->configure($user->getId(),User::OBJECT_DATA_MANAGER);
        $statisticManager->setObject(User::OBJECT_DATA_BOOKMARK_REGISTER);
        $statisticManager->countStatisticsMonth();
    }

    /**
     * Registra manejador de objetos
     *
     * @param   ObjectDataManagerInterface  $objectDataManager
     */
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setObjectDataManager(ObjectDataManagerInterface $objectDataManager)
    {
        $this->objectDataManager = $objectDataManager;
    }
}