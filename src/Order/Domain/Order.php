<?php

namespace App\Order\Domain;

use App\Order\Domain\ValueObject\OrderId;
use DateTimeImmutable;

/**
 * Nombre: Order
 * Descripción: Entidad principal Order. Representa una orden de compra.
 * Fecha de desarrollo: 07/08/2025, autor: Aythami Melián Perdomo.
 */
class Order
{
    private OrderId $orderId;
    private string $cartId;
    private array $products; // [ [productId, quantity], ... ]
    private DateTimeImmutable $createdAt;

    public function __construct(OrderId $orderId, string $cartId, array $products)
    {
        $this->orderId = $orderId;
        $this->cartId = $cartId;
        $this->products = $products;
        $this->createdAt = new DateTimeImmutable();
    }

    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    public function getCartId(): string
    {
        return $this->cartId;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Crea una orden desde el carrito.
     * @param string $cartId
     * @param array $items [ [productId, quantity], ... ]
     * @return Order
     */
    public static function fromCart(string $cartId, array $items): self
    {
        $orderId = OrderId::generate();
        $products = [];
        foreach ($items as $item) {
            $products[] = [
                'productId' => $item['productId'],
                'quantity' => $item['quantity'],
            ];
        }
        return new self($orderId, $cartId, $products);
    }
}
