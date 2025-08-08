<?php

namespace App\Cart\Domain;

/**
 * Nombre: CartRepositoryInterface
 * Descripción: Contrato para repositorios de persistencia del carrito.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
interface CartRepositoryInterface
{
    public function findById(string $cartId): ?Cart;
    public function save(Cart $cart): void;
    public function delete(string $cartId): void;
}
