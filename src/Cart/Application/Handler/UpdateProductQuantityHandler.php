<?php

namespace App\Cart\Application\Handler;

use App\Cart\Application\Command\UpdateProductQuantityCommand;
use App\Cart\Domain\CartRepositoryInterface;

/**
 * Nombre: UpdateProductQuantityHandler
 * Descripción: Handler CQRS para actualizar la cantidad.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
class UpdateProductQuantityHandler
{
    private CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function __invoke(UpdateProductQuantityCommand $command): void
    {
        $cart = $this->cartRepository->findById($command->cartId);
        if (!$cart) {
            throw new \Exception('Carrito no encontrado');
        }
        $cart->updateItem($command->productId, $command->quantity);
        $this->cartRepository->save($cart);
    }
}
