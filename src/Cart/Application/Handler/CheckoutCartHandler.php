<?php

namespace App\Cart\Application\Handler;

use App\Cart\Application\Command\CheckoutCartCommand;
use App\Cart\Domain\CartRepositoryInterface;
use App\Order\Domain\OrderRepositoryInterface;
use App\Order\Domain\Order;

/**
 * Nombre: CheckoutCartHandler
 * Descripción: Handler para checkout, crea una Order y vacía el carrito.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
class CheckoutCartHandler
{
    private CartRepositoryInterface $cartRepository;
    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(CheckoutCartCommand $command): void
    {
        $cart = $this->cartRepository->findById($command->cartId);

        if (!$cart) {
            throw new \Exception('Carrito no encontrado');
        }

        $items = [];
        foreach ($cart->getItems() as $item) {
            $items[] = [
                'productId' => $item->getProductId(),
                'quantity' => $item->getQuantity(),
            ];
        }

        if (empty($items)) {
            throw new \Exception('El carrito está vacío');
        }

        $order = Order::fromCart($cart->getId()->value(), $items);
        $this->orderRepository->save($order);

        $cart->clear();
        $this->cartRepository->save($cart);
    }
}
