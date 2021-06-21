<?php
require('entity/Cart.php');

use entity\Cart;
\session_start();

$user = $_SESSION['user'] ?? null;
$cart = $_SESSION['cart'] ?? new Cart();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Boutique</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/content.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg d-inline-block fixed-top navbar-dark bg-dark"><a class="navbar-brand" href="#">Navbar</a>
    <div class="navbar-nav float-right d-inline">
        <a href="#" id="cart-trigger" class="mr-2"><i class="fa fa-shopping-cart text-primary fa-2x" aria-hidden="true"></i> <span>Cart(<span id="cart-count"><?php echo \count($cart->getProducts()) ?></span>)</span></a>
        <a <?php if (!$user) { echo 'href="login"'; } ?>><i class="fa fa-user-circle <?php if ($user) { echo 'color-green'; } ?> fa-2x" aria-hidden="true"></i></a>
        <?php if ($user) { ?><a href="logout"><i class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a><?php } ?>
    </div>
</nav>
<nav class="nav left-nav d-inline-block nav-column categories"></nav>
<div class="container d-inline-block mt-70 mb-50 main-content">
    <div class="row d-inline-block products-listing"></div>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="js/products.js"></script>
</body>
</html>


