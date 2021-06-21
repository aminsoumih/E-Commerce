<?php

namespace entity;

/**
 * for table product.
 */
class Product
{
    /**
     * @var int
     */
    private $sku;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $upc;
    /**
     * @var float
     */
    private $price;
    /**
     * @var float
     */
    private $shipping;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $manufacturer;
    /**
     * @var string
     */
    private $model;
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $image;
    /**
     * @var array<Category>
     */
    private $categories;

    /**
     * @return int
     */
    public function getSku(): int
    {
        return $this->sku;
    }

    /**
     * @param int $sku
     */
    public function setSku(int $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getUpc(): string
    {
        return $this->upc;
    }

    /**
     * @param string $upc
     */
    public function setUpc(string $upc): void
    {
        $this->upc = $upc;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getShipping(): float
    {
        return $this->shipping;
    }

    /**
     * @param float $shipping
     */
    public function setShipping(float $shipping): void
    {
        $this->shipping = $shipping;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getManufacturer(): string
    {
        return $this->manufacturer;
    }

    /**
     * @param string $manufacturer
     */
    public function setManufacturer(string $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel(string $model): void
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
    }

    public function toArray(): array
    {
        return [
            'sku' => $this->sku,
            'name' => $this->sku,
            'type' => $this->sku,
            'upc' => $this->sku,
            'price' => $this->sku,
            'shipping' => $this->sku,
            'description' => $this->sku,
            'manufacturer' => $this->sku,
            'model' => $this->sku,
            'url' => $this->sku,
            'image' => $this->sku,
            'categories' => \array_map(function ($category) {
                return $category->toArray();
            }, $this->categories),
        ];
    }
}