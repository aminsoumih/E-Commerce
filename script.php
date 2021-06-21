<?php
ini_set('memory_limit', '512M' ); // large file
require('inc/parameters.inc.php');
require('inc/lib.php');

$result = 'Succesfully added data to db';
$db = \getDbConnection($host, $username, $password);
if ($db instanceof PDOException) {
    echo '<h1>unable to connect to DB</h1>';
    echo '<h4>error message: '.$db->getMessage().'</h4>';
    die;
}
// load products from json file
$products = \json_decode(\utf8_encode(\file_get_contents('products.json')), true);
$db->beginTransaction();
// add products to DB
try {
    foreach ($products as $product) {
        $db->prepare(
            'INSERT INTO boutique.product (sku,name,type,upc,price,shipping,description,manufacturer,model,url,image) 
        VALUES (?,?,?,?,?,?,?,?,?,?,?)'
        )->execute([
            $product['sku'],
            \normalize($product, 'name', null),
            \normalize($product, 'type', null),
            \normalize($product, 'upc', null),
            \normalize($product, 'price', 0.0),
            \normalize($product,'shipping', 0.0),
            \normalize($product, 'description', null),
            \normalize($product, 'manufacturer', null),
            \normalize($product, 'model', null),
            \normalize($product, 'url', null),
            \normalize($product, 'image', null),
        ]);
        array_walk($product['category'], function ($category) use ($db, $product) {
            // add category if not already added
            $db->prepare(
                'INSERT IGNORE INTO boutique.category (id, name) VALUES (?,?)'
            )->execute([
                $category['id'],
                $category['name'],
            ]);
            // assign product's category
            $db->prepare(
                'INSERT INTO boutique.product_category (product_id, category_id) VALUES (?,?)'
            )->execute([
                $product['sku'],
                $category['id']
            ]);
        });
    }
    $db->commit();
} catch (PDOException $e) {
    $db->rollBack();
    $result = 'Failed. Error message: ' . $e->getMessage()."\ntrace: ".$e->getTraceAsString();
}
echo $result;
