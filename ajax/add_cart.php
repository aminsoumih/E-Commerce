<?php
require('../inc/parameters.inc.php');
require('../inc/lib.php');
require('../entity/Category.php');
require('../entity/Product.php');
require('../entity/Cart.php');
\session_start();

use entity\Category;
use entity\Product;
use entity\Cart;

$db = \getDbConnection($host, $username, $password);
if ($db instanceof PDOException) {
    echo '<h1>unable to connect to DB</h1>';
    echo '<h4>error message: '.$db->getMessage().'</h4>';
    die;
}
$cart = $_SESSION['cart'] ?? new Cart();
$sku = $_POST['sku'] ?? null;
$qty = $_POST['qty'] ?? null;
if (is_numeric($qty) && $qty > 0 && $sku) {
    $product = null;
    try {
        // get product + its categories by sku
        $statment = $db->prepare(
            'SELECT p.*,c.id as category_id,c.name as category_name FROM product p JOIN product_category pc 
            ON p.sku = pc.product_id JOIN category c ON c.id = pc.category_id WHERE p.sku=:sku'
        );
        $statment->setFetchMode(\PDO::FETCH_CLASS, Product::class);
        $statment->bindParam(':sku', $sku, PDO::PARAM_INT);
        $statment->execute();
        $data = $statment->fetchAll();
    } catch (\Exception $e) {
       echo 'unable to add to cart';
    }
    if ($data) {
        // same product but many categories
        $product = $data[0];
        foreach ($data as $row) {
            $category = new Category();
            $category->setId($row->category_id);
            $category->setName($row->category_name);
            $product->addCategory($category);
        }
        $cart->addProduct($product, $qty);
    }
    $_SESSION['cart'] = $cart;
}