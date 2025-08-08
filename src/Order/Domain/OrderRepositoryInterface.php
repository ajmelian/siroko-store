<?php

namespace App\Order\Domain;

interface OrderRepositoryInterface
{
    public function save(Order $order): void;
    public function findById(string $orderId): ?Order;
    public function findAll(): array;
}
