<?php

namespace App\Tests\Cart\Domain;

use App\Cart\Domain\CartItem;
use PHPUnit\Framework\TestCase;

/**
 * Nombre: CartItemTest
 * Descripción: Pruebas unitarias para el ValueObject CartItem.
 * Autor: Aythami Melián Perdomo.
 * Fecha de desarrollo: 08/08/2025
 */
class CartItemTest extends TestCase
{
    public function testCreateCartItem()
    {
        $item = new CartItem('sku001', 2);
        $this->assertEquals('sku001', $item->getProductId());
        $this->assertEquals(2, $item->getQuantity());
    }

    public function testNegativeQuantityIsConvertedToOne()
    {
        $item = new CartItem('sku001', -5);
        $this->assertEquals(1, $item->getQuantity());
    }

    public function testWithQuantityReturnsNewInstance()
    {
        $item = new CartItem('sku001', 2);
        $newItem = $item->withQuantity(5);

        $this->assertNotSame($item, $newItem);
        $this->assertEquals(5, $newItem->getQuantity());
        $this->assertEquals(2, $item->getQuantity());
    }
}
