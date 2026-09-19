<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mercado Pago
    |--------------------------------------------------------------------------
    | Credenciales y opciones para el checkout de Mercado Pago.
    | Define MERCADOPAGO_ACCESS_TOKEN en tu archivo .env.
    */

    'access_token' => env('MERCADOPAGO_ACCESS_TOKEN'),

    'public_key' => env('MERCADOPAGO_PUBLIC_KEY'),

    // Moneda usada en las preferencias de pago (México = MXN).
    'currency' => env('MERCADOPAGO_CURRENCY', 'MXN'),
];
