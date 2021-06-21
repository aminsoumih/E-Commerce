<?php
require('../inc/parameters.inc.php');
require('../inc/lib.php');
require('../entity/Category.php');

use entity\Category;

$db = \getDbConnection($host, $username, $password);
if ($db instanceof PDOException) {
    echo '<h1>unable to connect to DB</h1>';
    echo '<h4>error message: '.$db->getMessage().'</h4>';
    die;
}
$offset = 0;
try {
    $statment = $db->prepare(
        'SELECT pc.category_id as id,c.name as name,count(pc.product_id) as count from product_category pc, category c WHERE c.id = pc.category_id GROUP BY pc.category_id ORDER BY c.name;'
    );
    $statment->setFetchMode(\PDO::FETCH_CLASS, Category::class);
    $statment->execute();
    $categories = $statment->fetchAll();
} catch (\Exception $e) {
    $categories = [];
}
/**
 * @var Category $category
 */
?>

<?php foreach ($categories as $category) { ?>
    <a class="nav-link" href="<?php echo $category->getId(); ?>"><?php echo $category->getName().'('.$category->getCount().')'; ?></a>
<?php } ?>
