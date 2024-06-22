<?php

namespace App\Services\User;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use App\Entity\M\Master\User\Security\Method;
use App\Entity\M\User;

/**
 * Manejador de seguridad
 * 
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class SecurityManager implements SecurityManagerInterface
{
    /**
     * Encriptador de password
     * @var NativePasswordHasher
     */
    private $hasher;

    /**
     * Hash que identifica operación
     */
    private $hash;

    private $processors = [];

    public function __construct(
        private \App\Services\User\Security\Processor\EmailProcessor $emailProcessor,
        private \App\Services\User\Security\Processor\PhoneProcessor $phoneProcessor,
        private \App\Services\User\Security\Processor\PasswordProcessor $passwordProcessor,
        )
    {
        $this->addProcessor($emailProcessor);
        $this->addProcessor($phoneProcessor);
        $this->addProcessor($passwordProcessor);
    }

    private function addProcessor($processor)
    {
        $this->processors[$processor->getName()] = $processor;
    }

    private function resolveProcessor($processor)
    {
        return $this->processors[$processor];
    }

    /**
     * Renderiza de formulario de actualización
     * @author Máximo Sojo <maxsojo13@gmail.com>
     */
    public function update(Request $request, Method $method)
    {
        $processor = $this->resolveProcessor($method->getId());
        return $processor->update($request,$method);
    }

    /**
     * Renderiza de formulario
     * 
     * @author Máximo Sojo <maxsojo13@gmail.com>
     */
    public function validate(Request $request, Method $method)
    {
        $processor = $this->resolveProcessor($method->getId());
        return $processor->validate($request,$method);
    }

    /**
     * Renderiza de formulario
     * 
     * @author Máximo Sojo <maxsojo13@gmail.com>
     */
    public function reset(Request $request, Method $method)
    {
        $processor = $this->resolveProcessor($method->getId());
        return $processor->reset($request,$method);
    }

    /**
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * 
     * @return NativePasswordHasher
     */
    private function getHasher()
    {
        if ($this->hasher === null) {
            $this->hasher = new NativePasswordHasher();
        }

        return $this->hasher;
    }

    /**
     * Codifica un plainPassword
     * @param User $user
     * @param type $pin
     * @return type
     */
    public function passwordHash($plainPassword)
    {
        return $this->getHasher()->hash($plainPassword);
    }

    /**
     * Verifica un plainPassword
     * @param User $user
     * @param type $pin
     * @return type
     */
    public function passwordVerify($hashedPassword, $plainPassword)
    {
        if($plainPassword === null){
            $plainPassword = "";
        }
        return $this->getHasher()->verify($hashedPassword,$plainPassword);
    }
}