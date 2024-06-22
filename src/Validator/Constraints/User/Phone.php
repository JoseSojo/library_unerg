<?php

namespace App\Validator\Constraints\User;

use Symfony\Component\Validator\Constraint;

/**
 * Phone validator
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class Phone extends Constraint
{
    /**
     * Targets
     */
    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}
