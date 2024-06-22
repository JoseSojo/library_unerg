<?php

namespace App\Validator\Constraints;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UniquePropertyValidator extends ConstraintValidator
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    private $propertyAccessor;

    public function __construct()
    {
        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param mixed $value
     * @param Constraint $constraint
     * @throws \Exception
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UniqueProperty) {
            throw new UnexpectedTypeException($constraint, UniqueProperty::class);
        }

        if (null === $value) {
            return;
        }

        if (!\is_array($value) && !$value instanceof \IteratorAggregate) {
            throw new UnexpectedValueException($value, 'array|IteratorAggregate');
        }

        if ($constraint->propertyPath === null) {
            throw new \Exception('Option propertyPath can not be null');
        }

        $propertyValues = [];
        foreach ($value as $key => $element) {
            $propertyValue = $this->propertyAccessor->getValue($element, $constraint->propertyPath);
            if (in_array($propertyValue, $propertyValues, true)) {
                $this->context->buildViolation($constraint->message)
                    ->atPath(sprintf('[%s]', $key))
                    ->addViolation();
            }

            $propertyValues[] = $propertyValue;
        }
    }
}