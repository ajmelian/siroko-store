<?php

namespace App\Tests\Order\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Nombre: OrderControllerTest
 * Descripción: Test de integración del flujo completo: añadir al carrito, checkout, listar órdenes.
 * Autor: Aythami Melián Perdomo.
 * Fecha de desarrollo: 08/08/2025
 */
class OrderControllerTest extends WebTestCase
{
    public function testCheckoutCreatesOrderAndOrderCanBeListed()
    {
        $client = static::createClient();

        // 1. Añadir productos al carrito
        $client->request(
            'POST',
            '/api/cart/orderflow/items',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => 'skuTest1', 'quantity' => 2])
        );
        $this->assertResponseIsSuccessful();

        $client->request(
            'POST',
            '/api/cart/orderflow/items',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['productId' => 'skuTest2', 'quantity' => 3])
        );
        $this->assertResponseIsSuccessful();

        // 2. Realizar checkout (crear orden)
        $client->request('POST', '/api/cart/orderflow/checkout');
        $this->assertResponseIsSuccessful();

        // 3. Verificar que el carrito queda vacío
        $client->request('GET', '/api/cart/orderflow/items');
        $cart = json_decode($client->getResponse()->getContent(), true);
        $this->assertCount(0, $cart['items']);

        // 4. Consultar órdenes creadas
        $client->request('GET', '/api/orders');
        $this->assertResponseIsSuccessful();

        $orders = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('orders', $orders);
        $this->assertGreaterThanOrEqual(1, count($orders['orders']));

        $found = false;
        foreach ($orders['orders'] as $order) {
            if ($order['cartId'] === 'orderflow') {
                $found = true;
                $this->assertEquals([
                    ['productId' => 'skuTest1', 'quantity' => 2],
                    ['productId' => 'skuTest2', 'quantity' => 3]
                ], $order['products']);
                $this->assertArrayHasKey('orderId', $order);
                $this->assertArrayHasKey('createdAt', $order);
            }
        }
        $this->assertTrue($found, 'La orden debe encontrarse en el listado de órdenes.');
    }
}
