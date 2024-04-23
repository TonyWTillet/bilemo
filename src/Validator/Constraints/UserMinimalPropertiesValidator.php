<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class UserMinimalPropertiesValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (array_diff(['firstname', 'lastname', 'email'], $value)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}