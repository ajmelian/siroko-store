<?php

namespace App\Tests\Cart\Application\Handler;

use App\Cart\Domain\Cart;
use App\Cart\Domain\ValueObject\CartId;
use App\Cart\Domain\CartRepositoryInterface;
use App\Cart\Application\Command\AddProductToCartCommand;
use App\Cart\Application\Handler\AddProductToCartHandler;
use App\Cart\Domain\CartItem;
use PHPUnit\Framework\TestCase;

/**
 * Nombre: AddProductToCartHandlerTest
 * Descripción: Prueba unitaria para AddProductToCartHandler usando un repositorio in-memory simulado.
 * Autor: Aythami Melián Perdomo.
 * Fecha de desarrollo: 08/08/2025
 */
class AddProductToCartHandlerTest extends TestCase
{
    public function testAddProductToCart()
    {
        $repo = new class implements CartRepositoryInterface {
            public ?Cart $cart = null;
            public function findById(string $cartId): ?Cart {
                return $this->cart;
            }
            public function save(Cart $cart): void {
                $this->cart = $cart;
            }
            public function delete(string $cartId): void {}
        };

        $handler = new AddProductToCartHandler($repo);
        $command = new AddProductToCartCommand('abcd-efgh-ijkl', 'sku-test', 2);

        $handler($command);

        $cart = $repo->cart;
        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertCount(1, $cart->getItems());
        $this->assertEquals('sku-test', $cart->getItems()[0]->getProductId());
        $this->assertEquals(2, $cart->getItems()[0]->getQuantity());
    }
}
