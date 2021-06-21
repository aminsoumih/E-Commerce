<?php
require('../inc/parameters.inc.php');
require('../inc/lib.php');
require('../entity/Category.php');
require('../entity/Product.php');
require('../entity/Cart.php');
\session_start();

use entity\Cart;

$cart = $_SESSION['cart'] ?? new Cart();

$products = [];
foreach ($cart->getProducts() as $product) {
    $products[] = $product['product']->toArray() + ['quantity' => $product['quantity']];
}

echo \json_encode($products);