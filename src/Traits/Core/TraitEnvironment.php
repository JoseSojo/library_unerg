<?php

namespace App\Traits\Core;

use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Interfaces\Core\EnvironmentInterface;

/**
 * Trait de modo activo
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
trait TraitEnvironment
{
    /**
     * Modo
     * @var string
     */
    protected $itemEnvironment;
    
    public function getItemEnvironment()
    {
        return $this->itemEnvironment;
    }

    public function setItemEnvironment($itemEnvironment)
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired("env");
        $resolver->setAllowedValues("env", self::getAllEnvironments());
        $resolver->resolve(["env" => $itemEnvironment]);
        
        $this->itemEnvironment = $itemEnvironment;
        return $this;
    }

    /**
     * Retorna todos los ambientes disponibles
     * @return array
     */
    public static function getAllEnvironments()
    {
        return [
            "choice.environment.development" => EnvironmentInterface::ENV_DEVELOPMENT,
            "choice.environment.quality" => EnvironmentInterface::ENV_QUALITY,
            "choice.environment.productive" => EnvironmentInterface::ENV_PRODUCTIVE,
        ];
    }
}
