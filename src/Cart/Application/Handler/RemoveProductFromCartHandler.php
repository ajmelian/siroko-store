<?php

namespace App\Cart\Application\Handler;

use App\Cart\Application\Command\RemoveProductFromCartCommand;
use App\Cart\Domain\CartRepositoryInterface;

/**
 * Nombre: RemoveProductFromCartHandler
 * Descripción: Handler CQRS para eliminar un producto.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
class RemoveProductFromCartHandler
{
    private CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function __invoke(RemoveProductFromCartCommand $command): void
    {
        $cart = $this->cartRepository->findById($command->cartId);
        if (!$cart) {
            throw new \Exception('Carrito no encontrado');
        }
        $cart->removeItem($command->productId);
        $this->cartRepository->save($cart);
    }
}
