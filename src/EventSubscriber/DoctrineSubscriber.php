<?php

/*
 * This file is part of the GTI SOLUTIONS, C.A. - J409603954 package.
 * 
 * (c) www.gtisolutions.com.ve
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\EventSubscriber;

use App\Entity\M\Master\Term;
use Maximosojo\ToolsBundle\Service\Util\StringUtil;
use Doctrine\Common\EventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Maximosojo\ToolsBundle\Interfaces\SequenceGenerator\ItemReferenceInterface;

/**
 * Subscriptor de eventos en doctrine
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class DoctrineSubscriber implements EventSubscriber 
{
    private $mySequenceGenerator;
    private $currencyService;

    use \Symfony\Component\DependencyInjection\ContainerAwareTrait;
    // public function __construct(private \Symfony\Component\Security\Core\Authentication\Token\Storage\UsageTrackingTokenStorage $usageTrackingTokenStorage)
    // {
    // }
    
    public function getSubscribedEvents()
    {              
        return [
            "prePersist"
        ];
    }
    
     /**
     * Checks for persisted Timestampable objects
     * to update creation and modification dates
     *
     * @param EventArgs $args
     *
     * @return void
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();        
        if($entity instanceof ItemReferenceInterface && empty($entity->getRef())) {
             $ref = $this->mySequenceGenerator->setRef($entity);
        }

        if($entity instanceof Term) {
            if (empty($entity->getSlug())) {
                $entity->setSlug(StringUtil::slugify($entity->getName()));
            }
        }
    }
    
    /**
     * Generador de secuencias
     * @return \App\Services\Core\SequenceGenerator\MySequenceGenerator
     */
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setSequenceGenerator(\App\Services\Core\SequenceGenerator\MySequenceGenerator $mySequenceGenerator)
    {
        return $this->mySequenceGenerator = $mySequenceGenerator;
    }
    
    /**
     * Get a user from the Security Token Storage.
     *
     * @return mixed
     *
     * @throws \LogicException If SecurityBundle is not available
     *
     * @see TokenInterface::getUser()
     *
     * @final since version 3.4
     */
    protected function getUser()
    {
        if (!$this->container->has('security.token_storage')) {
            throw new \LogicException('The SecurityBundle is not registered in your application. Try running "composer require symfony/security-bundle".');
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
    
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
    {
        $this->container = $container;
    }   
}
