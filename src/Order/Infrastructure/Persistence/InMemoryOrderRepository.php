<?php

namespace App\Order\Infrastructure\Persistence;

use App\Order\Domain\OrderRepositoryInterface;
use App\Order\Domain\Order;

/**
 * Nombre: InMemoryOrderRepository
 * Descripción: Implementación in-memory del repositorio de órdenes.
 * Fecha de desarrollo: 07/08/2025, autor: Aythami Melián Perdomo.
 */
class InMemoryOrderRepository implements OrderRepositoryInterface
{
    /** @var Order[] */
    private static array $orders = [];

    public function save(Order $order): void
    {
        self::$orders[$order->getOrderId()->value()] = $order;
    }

    public function findById(string $orderId): ?Order
    {
        return self::$orders[$orderId] ?? null;
    }

    public function findAll(): array
    {
        return array_values(self::$orders);
    }
}
