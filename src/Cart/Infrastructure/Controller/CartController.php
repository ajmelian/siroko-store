<?php

namespace App\Cart\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Cart\Application\Command\AddProductToCartCommand;
use App\Cart\Application\Handler\AddProductToCartHandler;
use App\Cart\Application\Command\UpdateProductQuantityCommand;
use App\Cart\Application\Handler\UpdateProductQuantityHandler;
use App\Cart\Application\Command\RemoveProductFromCartCommand;
use App\Cart\Application\Handler\RemoveProductFromCartHandler;
use App\Cart\Application\Query\GetCartItemsQuery;
use App\Cart\Application\Handler\GetCartItemsHandler;
use App\Cart\Application\Command\CheckoutCartCommand;
use App\Cart\Application\Handler\CheckoutCartHandler;

/**
 * Nombre: CartController
 * Descripción: Controlador HTTP para gestión completa del carrito (API REST, desacoplado).
 * Fecha de desarrollo: 07/08/2025, autor: Aythami Melián Perdomo.
 */
#[Route('/api/cart')]
class CartController extends AbstractController
{
    public function __construct(
        private AddProductToCartHandler $addProductToCartHandler,
        private UpdateProductQuantityHandler $updateProductQuantityHandler,
        private RemoveProductFromCartHandler $removeProductFromCartHandler,
        private GetCartItemsHandler $getCartItemsHandler,
        private CheckoutCartHandler $checkoutCartHandler
    ) {}

    #[Route('/{cartId}/items', name: 'cart_add_item', methods: ['POST'])]
    public function addProduct(string $cartId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $productId = $data['productId'] ?? null;
        $quantity = $data['quantity'] ?? 1;

        if (!$productId) {
            return $this->json(['error' => 'Falta productId'], 400);
        }

        $command = new AddProductToCartCommand($cartId, $productId, (int)$quantity);
        ($this->addProductToCartHandler)($command);

        return $this->json(['status' => 'ok']);
    }

    #[Route('/{cartId}/items', name: 'cart_list_items', methods: ['GET'])]
    public function listProducts(string $cartId): JsonResponse
    {
        $query = new GetCartItemsQuery($cartId);
        $items = ($this->getCartItemsHandler)($query);

        return $this->json(['items' => $items]);
    }

    #[Route('/{cartId}/items/{productId}', name: 'cart_update_item', methods: ['PUT'])]
    public function updateProduct(string $cartId, string $productId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $quantity = $data['quantity'] ?? null;

        if ($quantity === null || $quantity < 1) {
            return $this->json(['error' => 'Cantidad no válida'], 400);
        }

        $command = new UpdateProductQuantityCommand($cartId, $productId, (int)$quantity);

        try {
            ($this->updateProductQuantityHandler)($command);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 404);
        }

        return $this->json(['status' => 'ok']);
    }

    #[Route('/{cartId}/items/{productId}', name: 'cart_delete_item', methods: ['DELETE'])]
    public function deleteProduct(string $cartId, string $productId): JsonResponse
    {
        $command = new RemoveProductFromCartCommand($cartId, $productId);

        try {
            ($this->removeProductFromCartHandler)($command);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 404);
        }

        return $this->json(['status' => 'ok']);
    }

    #[Route('/{cartId}/checkout', name: 'cart_checkout', methods: ['POST'])]
    public function checkout(string $cartId): JsonResponse
    {
        $command = new CheckoutCartCommand($cartId);

        try {
            ($this->checkoutCartHandler)($command);
        } catch (\Exception $e) {
            return $this->json(['error' => $e->getMessage()], 404);
        }

        return $this->json(['status' => 'ok', 'message' => 'Checkout completado']);
    }
}
