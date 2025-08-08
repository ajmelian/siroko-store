<?php

namespace App\Cart\Application\Handler;

use App\Cart\Application\Query\GetCartItemsQuery;
use App\Cart\Domain\CartRepositoryInterface;

/**
 * Nombre: GetCartItemsHandler
 * Descripción: Handler para la query de listar productos.
 * Fecha de desarrollo: 06/08/2025, autor: Aythami Melián Perdomo.
 */
class GetCartItemsHandler
{
    private CartRepositoryInterface $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * @param GetCartItemsQuery $query
     * @return array
     */
    public function __invoke(GetCartItemsQuery $query): array
    {
        $cart = $this->cartRepository->findById($query->cartId);
        if (!$cart) {
            return [];
        }
        $items = [];
        foreach ($cart->getItems() as $item) {
            $items[] = [
                'productId' => $item->getProductId(),
                'quantity' => $item->getQuantity()
            ];
        }
        return $items;
    }
}
