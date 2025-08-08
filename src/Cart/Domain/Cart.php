<?php

namespace App\Cart\Domain;

use App\Cart\Domain\CartItem;
use App\Cart\Domain\ValueObject\CartId;

/**
 * Nombre: Cart
 * Descripción: Entidad agregada principal del dominio Cart. Gestiona los ítems de la cesta de compra.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
class Cart
{
    private CartId $id;
    /** @var CartItem[] */
    private array $items = [];

    public function __construct(CartId $id, array $items = [])
    {
        $this->id = $id;
        $this->items = $items;
    }

    public function getId(): CartId
    {
        return $this->id;
    }

    public function addItem(CartItem $item): void
    {
        foreach ($this->items as $key => $existingItem) {
            if ($existingItem->getProductId() === $item->getProductId()) {
                $this->items[$key] = $item;
                return;
            }
        }
        $this->items[] = $item;
    }

    public function removeItem(string $productId): void
    {
        foreach ($this->items as $key => $item) {
            if ($item->getProductId() === $productId) {
                unset($this->items[$key]);
                $this->items = array_values($this->items);
                return;
            }
        }
    }

    public function updateItem(string $productId, int $quantity): void
    {
        foreach ($this->items as $key => $item) {
            if ($item->getProductId() === $productId) {
                $this->items[$key] = $item->withQuantity($quantity);
                return;
            }
        }
    }

    /** @return CartItem[] */
    public function getItems(): array
    {
        return $this->items;
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function countTotalItems(): int
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->getQuantity();
        }
        return $total;
    }
}
