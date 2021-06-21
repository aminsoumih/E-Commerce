<?php
require('../inc/parameters.inc.php');
require('../inc/lib.php');
require('../entity/Product.php');

use entity\Product;

$db = \getDbConnection($host, $username, $password);
if ($db instanceof PDOException) {
    echo '<h1>unable to connect to DB</h1>';
    echo '<h4>error message: '.$db->getMessage().'</h4>';
    die;
}
$offset = $_POST['offset'] ?? 0;
$limit = $_POST['limit'] ?? 30;
try {
    $statment = $db->prepare(
        'SELECT * FROM product ORDER BY SKU LIMIT :limit OFFSET :offset'
    );
    $statment->setFetchMode(\PDO::FETCH_CLASS, Product::class);
    $statment->bindParam(':limit', $limit, PDO::PARAM_INT);
    $statment->bindParam(':offset', $offset, PDO::PARAM_INT);
    $statment->execute();
    $products = $statment->fetchAll();
} catch (\Exception $e) {
    $products = [];
}
?>

<?php foreach ($products as $product) { ?>
            <div class="card card-body d-inline-block w-100">
                <div class="media align-items-center align-items-lg-start text-center text-lg-left">
                    <div class="mr-2 mb-3 mb-lg-0"> <img src="<?php echo $product->getImage(); ?>" width="150" height="150" alt=""> </div>
                    <div class="media-body">
                        <h6 class="media-title font-weight-semibold"> <?php echo $product->getName(); ?></h6>
                        <ul class="list-inline list-inline-dotted mb-3 mb-lg-2">
                            <li class="list-inline-item"><a href="#" class="text-muted" data-abc="true"><?php echo $product->getType(); ?></a></li>
                        </ul>
                        <p class="mb-3"><?php echo $product->getDescription(); ?></p>
                        <ul class="list-inline list-inline-dotted mb-0">
                            <li class="list-inline-item">From <?php echo $product->getManufacturer(); ?></li>
                        </ul>
                    </div>
                    <div class="mt-3 mt-lg-0 ml-lg-3 text-center">

                        <h3 class="mb-3 font-weight-semibold"><?php echo $product->getPrice(); ?> DH</h3>
                        <div class="text-muted">Shipping: <?php echo $product->getShipping(); ?> DH</div>
                        <div class="qty-wrapper">Quantity: <input type="number" name="qty" id="qty-<?php echo $product->getSku(); ?>" value="0"/></div>
                        <button type="button" data-sku="<?php echo $product->getSku(); ?>"
                                class="btn btn-warning mt-4 text-white add-cart">
                            <i class="fa fa-cart-plus mr-2"></i> Add to Cart</button>
                    </div>
                </div>
            </div>
<?php } ?>
