<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Dni extends Constraint
{
    public $message = 'El DNI "{{ value }}" no es válido.';

    public function validatedBy()
    {
        return \App\Validator\DniValidator::class;
    }
}

