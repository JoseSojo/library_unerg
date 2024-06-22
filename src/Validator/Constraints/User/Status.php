<?php

namespace App\Validator\Constraints\User;

use Symfony\Component\Validator\Constraint;

/**
 * Status validator
 * @author Máximo Sojo <maxsojo13@gmail.com>
 */
class Status extends Constraint
{
    /**
     * Targets
     */
    public function getTargets(): string|array
    {
        return self::CLASS_CONSTRAINT;
    }
}
