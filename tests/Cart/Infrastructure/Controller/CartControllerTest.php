<?php

namespace App\Tests\Cart\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Nombre: CartControllerTest
 * Descripción: Test de integración REST de los endpoints del carrito.
 * Autor: Aythami Melián Perdomo.
 * Fecha de desarrollo: 08/08/2025
 */
class CartControllerTest extends WebTestCase
{
    public function testAddProductToCartAndListItems()
    {
        $client = static::createClient();

        // Añadir producto
        $client->request(
            'POST',
            '/api/cart/testcart/items',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => 'sku001', 'quantity' => 2])
        );
        $this->assertResponseIsSuccessful();

        // Listar productos
        $client->request('GET', '/api/cart/testcart/items');
        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('items', $data);
        $this->assertCount(1, $data['items']);
        $this->assertEquals('sku001', $data['items'][0]['productId']);
        $this->assertEquals(2, $data['items'][0]['quantity']);
    }

    public function testUpdateProductQuantity()
    {
        $client = static::createClient();

        // Añadir producto
        $client->request(
            'POST',
            '/api/cart/testcart2/items',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => 'skuX', 'quantity' => 1])
        );
        $this->assertResponseIsSuccessful();

        // Actualizar cantidad
        $client->request(
            'PUT',
            '/api/cart/testcart2/items/skuX',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['quantity' => 5])
        );
        $this->assertResponseIsSuccessful();

        // Comprobar resultado
        $client->request('GET', '/api/cart/testcart2/items');
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals(5, $data['items'][0]['quantity']);
    }

    public function testDeleteProductFromCart()
    {
        $client = static::createClient();

        // Añadir producto
        $client->request(
            'POST',
            '/api/cart/testcart3/items',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => 'skuDEL', 'quantity' => 2])
        );
        $this->assertResponseIsSuccessful();

        // Eliminar producto
        $client->request('DELETE', '/api/cart/testcart3/items/skuDEL');
        $this->assertResponseIsSuccessful();

        // Comprobar que el carrito está vacío
        $client->request('GET', '/api/cart/testcart3/items');
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertCount(0, $data['items']);
    }

    public function testCheckoutCart()
    {
        $client = static::createClient();

        // Añadir producto
        $client->request(
            'POST',
            '/api/cart/testcart4/items',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => 'skuCO', 'quantity' => 2])
        );
        $this->assertResponseIsSuccessful();

        // Realizar checkout
        $client->request('POST', '/api/cart/testcart4/checkout');
        $this->assertResponseIsSuccessful();

        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('Checkout completado', $data['message']);

        // Verificar que el carrito queda vacío
        $client->request('GET', '/api/cart/testcart4/items');
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertCount(0, $data['items']);
    }
}
