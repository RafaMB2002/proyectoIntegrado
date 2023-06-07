<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DniValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (empty($value)) {
            return;
        }

        if (!$this->validarDNIEspanol($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }

    private function validarDNIEspanol($dni)
    {
        // Verificar que el DNI tenga 9 caracteres (8 dígitos y 1 letra)
        if (strlen($dni) !== 9) {
            return false;
        }

        // Extraer los números del DNI
        $numeroDNI = substr($dni, 0, 8);

        // Extraer la letra de control del DNI
        $letraControl = strtoupper(substr($dni, -1));

        // Calcular el resto y obtener el índice correspondiente en el mapeo de letras
        $resto = $numeroDNI % 23;
        $mapeoLetras = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $letraCalculada = $mapeoLetras[$resto];

        // Comparar la letra de control ingresada con la letra calculada
        if ($letraControl === $letraCalculada) {
            return true; // DNI válido
        } else {
            return false; // DNI inválido
        }
    }
}
