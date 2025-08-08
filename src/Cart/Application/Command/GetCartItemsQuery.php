<?php

namespace App\Cart\Application\Query;

/**
 * Nombre: GetCartItemsQuery
 * Descripción: Query para obtener los productos del carrito.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
class GetCartItemsQuery
{
    public string $cartId;

    public function __construct(string $cartId)
    {
        $this->cartId = $cartId;
    }
}
