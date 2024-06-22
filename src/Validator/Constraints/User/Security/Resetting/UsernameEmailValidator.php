<?php

namespace App\Validator\Constraints\User\Security\Resetting;

use App\Validator\Constraints\ConstraintValidator;
use Symfony\Component\Validator\Constraint;
use FOS\UserBundle\Model\UserManagerInterface;

/**
 * Validacion de recuperar por nombre de usurio o email
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class UsernameEmailValidator extends ConstraintValidator 
{
    private $userManager;

    /**
     * @param Object $object
     * @param Constraint $constraint
     */
    public function validate($object, Constraint $constraint)
    {
        //Si hay errores no hay que seguir evaluando.
        if($this->hasErrors()){
            return;
        }

        $username = $object->getUsername();
        $user = $this->userManager->findUserByUsernameOrEmail($username);
        if ($user) {
            if (is_null($user->getPasswordRequestedAt())) {
                // Regista token
                $user->setConfirmationToken(\App\Services\Util\UserUtil::generateToken());
                $user->setPasswordRequestedAt(new \DateTime());
                // Ejecuta evento para envío de email
                $this->dispatch(\App\AppEvents::APP_SECURITY_RESETTING_EMAIL_REQUEST_PRE_SUCCESS,$this->newGenericEvent($user));
                // Actualizar usuario
                $this->userManager->updateUser($user);
                // Confirma solicitud
                $this->dispatch(\App\AppEvents::APP_SECURITY_RESETTING_EMAIL_REQUEST_POST_SUCCESS,$this->newGenericEvent($user));
            } else {
                $this->addError("validators.user.resetting.initialize.error");
            }
        }
    }

    /**
     * UserManagerInterface
     *
     * @param   UserManagerInterface  $userManager
     */
    #[\Symfony\Contracts\Service\Attribute\Required]
    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }
}
