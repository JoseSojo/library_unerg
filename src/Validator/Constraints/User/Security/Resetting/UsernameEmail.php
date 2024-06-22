<?php

namespace App\Validator\Constraints\User\Security\Resetting;

use Symfony\Component\Validator\Constraint;

/**
 * Validacion de recuperar por nombre de usurio o email
 *
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class UsernameEmail extends Constraint
{
    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}
