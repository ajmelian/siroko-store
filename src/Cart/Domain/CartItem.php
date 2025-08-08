<?php

namespace App\Cart\Domain;

/**
 * Nombre: CartItem
 * Descripción: ValueObject que representa un ítem de producto dentro del carrito.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
class CartItem
{
    private string $productId;
    private int $quantity;

    public function __construct(string $productId, int $quantity)
    {
        $this->productId = $productId;
        $this->quantity = max(1, $quantity);
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function withQuantity(int $quantity): CartItem
    {
        return new self($this->productId, $quantity);
    }
}
