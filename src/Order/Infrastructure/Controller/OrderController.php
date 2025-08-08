<?php

namespace App\Order\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Order\Domain\OrderRepositoryInterface;

/**
 * Nombre: OrderController
 * Descripción: Controlador para listar órdenes generadas.
 * Fecha de desarrollo: 07/08/2025, autor: Aythami Melián Perdomo.
 */
#[Route('/api/orders')]
class OrderController extends AbstractController
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository
    ) {}

    #[Route('', name: 'order_list', methods: ['GET'])]
    public function listOrders(): JsonResponse
    {
        $orders = $this->orderRepository->findAll();

        $result = [];
        foreach ($orders as $order) {
            $result[] = [
                'orderId' => (string)$order->getOrderId(),
                'cartId' => $order->getCartId(),
                'products' => $order->getProducts(),
                'createdAt' => $order->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        }

        return $this->json(['orders' => $result]);
    }
}
