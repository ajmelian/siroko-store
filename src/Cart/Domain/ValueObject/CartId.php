<?php

namespace App\Cart\Domain\ValueObject;

/**
 * Nombre: CartId
 * Descripción: ValueObject que representa el identificador único de un carrito.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
class CartId
{
    private string $id;

    public function __construct(string $id)
    {
        if (!preg_match('/^[a-f0-9\-]{4,}$/i', $id)) {
            throw new \InvalidArgumentException('CartId inválido');
        }
        $this->id = $id;
    }

    public function value(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
