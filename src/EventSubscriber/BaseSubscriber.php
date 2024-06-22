<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Maximosojo\ToolsBundle\Traits\Component\TranslatorTrait;

/**
 * Base de suscriptor de eventos
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
abstract class BaseSubscriber implements EventSubscriberInterface
{    
    use TranslatorTrait;
    use \App\Traits\DoctrineTrait;
}
