<?php

namespace App\Order\Domain\ValueObject;

/**
 * Nombre: OrderId
 * Descripción: ValueObject identificador único de una orden.
 * Fecha de desarrollo: 07/08/2025, autor: Aythami Melián Perdomo.
 */
class OrderId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function generate(): self
    {
        return new self(self::uuidV4());
    }

    public function value(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    private static function uuidV4(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}
