<?php

namespace App\Cart\Infrastructure\Persistence;

use App\Cart\Domain\CartRepositoryInterface;
use App\Cart\Domain\Cart;
use App\Cart\Domain\ValueObject\CartId;

/**
 * Nombre: InMemoryCartRepository
 * Descripción: Implementación temporal de CartRepositoryInterface usando memoria (array estático).
 * Fecha de desarrollo: 07/08/2025, autor: Aythami Melián Perdomo.
 */
class InMemoryCartRepository implements CartRepositoryInterface
{
    /** @var Cart[] */
    private static array $carts = [];

    public function findById(string $cartId): ?Cart
    {
        return self::$carts[$cartId] ?? null;
    }

    public function save(Cart $cart): void
    {
        self::$carts[$cart->getId()->value()] = $cart;
    }

    public function delete(string $cartId): void
    {
        unset(self::$carts[$cartId]);
    }
}
