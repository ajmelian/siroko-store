<?php

namespace App\Cart\Application\Command;

/**
 * Nombre: RemoveProductFromCartCommand
 * Descripción: Command para eliminar producto del carrito.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
class RemoveProductFromCartCommand
{
    public string $cartId;
    public string $productId;

    public function __construct(string $cartId, string $productId)
    {
        $this->cartId = $cartId;
        $this->productId = $productId;
    }
}
