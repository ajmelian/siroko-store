<?php

namespace App\Tests\Cart\Domain;

use App\Cart\Domain\Cart;
use App\Cart\Domain\CartItem;
use App\Cart\Domain\ValueObject\CartId;
use PHPUnit\Framework\TestCase;

/**
 * Nombre: CartTest
 * Descripción: Pruebas unitarias para la entidad Cart.
 * Autor: Aythami Melián Perdomo.
 * Fecha de desarrollo: 08/08/2025
 */
class CartTest extends TestCase
{
    public function testAddAndListItems()
    {
        $cart = new Cart(new CartId('11111111-1111-1111-1111-111111111111'));
        $cart->addItem(new CartItem('sku100', 3));
        $cart->addItem(new CartItem('sku200', 2));

        $items = $cart->getItems();
        $this->assertCount(2, $items);
        $this->assertEquals('sku100', $items[0]->getProductId());
        $this->assertEquals(3, $items[0]->getQuantity());
        $this->assertEquals('sku200', $items[1]->getProductId());
    }

    public function testRemoveItem()
    {
        $cart = new Cart(new CartId('11111111-1111-1111-1111-111111111111'));
        $cart->addItem(new CartItem('sku100', 1));
        $cart->removeItem('sku100');
        $this->assertCount(0, $cart->getItems());
    }

    public function testUpdateItemQuantity()
    {
        $cart = new Cart(new CartId('11111111-1111-1111-1111-111111111111'));
        $cart->addItem(new CartItem('sku100', 1));
        $cart->updateItem('sku100', 5);

        $items = $cart->getItems();
        $this->assertEquals(5, $items[0]->getQuantity());
    }

    public function testClearCart()
    {
        $cart = new Cart(new CartId('11111111-1111-1111-1111-111111111111'));
        $cart->addItem(new CartItem('sku100', 1));
        $cart->addItem(new CartItem('sku200', 1));
        $cart->clear();

        $this->assertCount(0, $cart->getItems());
    }
}
