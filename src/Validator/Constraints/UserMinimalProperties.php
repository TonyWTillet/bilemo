<?php

namespace App\Validator\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute] class UserMinimalProperties extends Constraint
{
    public string $message = 'The user must have a firstname, lastname and an email.';
}