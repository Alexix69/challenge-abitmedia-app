<?php

namespace App\Utils;

class ValidationMessages
{
    const LICENSE_MESSAGES = [
        'required' => 'El campo :attribute es obligatorio.',
        'unique' => ':attribute ya existe.',
        'size' => 'La longitud del campo :attribute debe ser :size.',
        'string' => 'El valor del campo :attribute debe ser una cadena de texto.',
        'integer' => 'El valor del campo :attribute debe ser un entero.',
        'max' => 'La longitud del campo :attribute es de máximo :max caracteres.',
        'numeric' => 'El valor del campo :attribute debe ser numérico.',
        'gt' => 'Ingrese un valor mayor a cero en :attribute.'
    ];

    const SERVICE_MESSAGES = [
        'required' => 'El campo :attribute es obligatorio.',
        'unique' => ':attribute ya existe.',
        'size' => 'La longitud del campo :attribute debe ser :size.',
        'string' => 'El valor del campo :attribute debe ser una cadena de texto.',
        'max' => 'La longitud del campo :attribute es de máximo :max caracteres.',
        'numeric' => 'El valor del campo :attribute debe ser numérico.',
        'gt' => 'Ingrese un valor mayor a cero en :attribute.',
    ];
}
