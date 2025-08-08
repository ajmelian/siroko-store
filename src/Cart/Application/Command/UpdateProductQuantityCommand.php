<?php

namespace App\Cart\Application\Command;

/**
 * Nombre: UpdateProductQuantityCommand
 * Descripción: Command para actualizar la cantidad de un producto en el carrito.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
class UpdateProductQuantityCommand
{
    public string $cartId;
    public string $productId;
    public int $quantity;

    public function __construct(string $cartId, string $productId, int $quantity)
    {
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
}
