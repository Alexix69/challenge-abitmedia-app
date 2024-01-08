<?php

namespace App\Utils;

class Validations
{
    const LICENSE_RULES = [
        'sku' => 'required|unique:software,sku|size:10',
        'type' => 'required|max:255|string',
        'os' => 'required|integer|gt:0',
        'price' => 'required|numeric|gt:0',
        'stock' => 'required|integer',
    ];

    const SERVICE_RULES = [
        'sku' => 'required|unique:services,sku|size:10',
        'description' => 'required|string|max:255',
        'price' => 'required|numeric|gt:0',
    ];
}
