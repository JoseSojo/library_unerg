<?php

namespace App\Validator\Constraints\User;

use Symfony\Component\Validator\Constraint;
use App\Validator\Constraints\ConstraintValidator;

/**
 * Validador de estatus del usuario para realizar una transacción
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class StatusValidator extends ConstraintValidator
{
    /**
     * Validador
     *  
     * @author Máximo Sojo <maxsojo13@gmail.com>
     * @param  [type]     $object
     * @param  Constraint $constraint
     * @return [type]
     */
    public function validate($object, Constraint $constraint)
    {
        //Si hay errores no hay que seguir evaluando.
        if($this->hasErrors()){
            return;
        }

        // $user = $this->getUser();
        // if (!$user->isValidated()) {
        //     $this->addError("validators.user.status.not_validated");
        // }
    }
}
