<?php

namespace App\Cart\Application\Handler;

use App\Cart\Application\Command\AddProductToCartCommand;
use App\Cart\Domain\CartRepositoryInterface;
use App\Cart\Domain\Cart;
use App\Cart\Domain\CartItem;
use App\Cart\Domain\ValueObject\CartId;

/**
 * Nombre: AddProductToCartHandler
 * Descripción: Handler de CQRS para el comando de añadir producto.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
class AddProductToCartHandler
{
    private CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function __invoke(AddProductToCartCommand $command): void
    {
        $cart = $this->cartRepository->findById($command->cartId)
            ?? new Cart(new CartId($command->cartId));

        $cart->addItem(new CartItem($command->productId, $command->quantity));
        $this->cartRepository->save($cart);
    }
}
