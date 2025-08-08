<?php

namespace App\Cart\Application\Command;

/**
 * Nombre: CheckoutCartCommand
 * Descripción: Command para procesar el checkout del carrito.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
class CheckoutCartCommand
{
    public string $cartId;

    public function __construct(string $cartId)
    {
        $this->cartId = $cartId;
    }
}
