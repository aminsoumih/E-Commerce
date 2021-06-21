<?php

namespace entity;

/**
 * for session cart.
 */
class Cart
{
    /**
     * @var int
     */
    private $userId;
    /**
     * @var array<mixed>
     */
    private $products;

    public function __construct()
    {
        $this->userId = null;
        $this->products = [];
    }

    /**
     * @return int
     */
    public function getUserId(): ?int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param array $product
     */
    public function addProduct(Product $product, int $quantity): void
    {
        $this->products[] = [
            'product' => $product,
            'quantity' => $quantity,
        ];
    }
}