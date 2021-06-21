<?php
require('inc/parameters.inc.php');
require('inc/lib.php');
require('entity/User.php');
require('entity/Cart.php');
\session_start();

use entity\User;
use entity\Cart;

$db = \getDbConnection($host, $username, $password);
if ($db instanceof PDOException) {
    echo '<h1>unable to connect to DB</h1>';
    echo '<h4>error message: '.$db->getMessage().'</h4>';
    die;
}
$errors = [];
$user = null;
if (isset($_POST['login'])) {
    try {
        $statment = $db->prepare(
            'SELECT * FROM user WHERE name = :username'
        );
        $statment->setFetchMode(\PDO::FETCH_CLASS, User::class);
        $statment->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $statment->execute();
        $user = $statment->fetch();
        if (!$user || !password_verify($_POST['password'], $user->getPassword())) {
            $errors[] = 'bad login/password. Please try again';
        }
    } catch (\PDOException $e) {
        $errors[] = 'can not connect';
    }
}
if (isset($_POST['register'])) {
    try {
        $statment = $db->prepare(
            'SELECT * FROM user WHERE name = :username'
        );
        $statment->setFetchMode(\PDO::FETCH_CLASS, User::class);
        $statment->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
        $statment->execute();
        $user = $statment->fetch();
        if (!$user) {
            $statment = $db->prepare(
                'INSERT INTO user (name, password) VALUES (?, ?)'
            );
            $username = $_POST['username'];
            $password = \password_hash($_POST['password'], PASSWORD_DEFAULT);
            $statment->execute([$username, $password]);
            $user = new User();
            $user->setName($username);
            $user->setPassword($password);
            $user->setId($db->lastInsertId());
        } else {
            $errors[] = 'username already exists';
        }
    } catch (\PDOException $e) {
        $errors[] = 'unable to connect';
    }
}
if ($user && !$errors) {
    $_SESSION['user'] = $user;
    $cart = $_SESSION['cart'] = $_SESSION['cart'] ?? new Cart();
    if (!$cart->getUserId()) { // new cart
        $cart->setUserId($user->getId());
    } elseif ($cart->getUserId() !== $user->getId()) { // different user connected with new cart
        $cart = $_SESSION['cart'] = new Cart();
    }
    header('Location: index');
    die;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Boutique</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div id="login">
        <h3 class="text-center text-white pt-5">Login form</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <div class="form-group">
                                <label for="username" class="text-info">Username:</label><br>
                                <input type="text" name="username" id="username" class="form-control" value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>">
                            </div>
                            <?php foreach ($errors as $error) {?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="submit" name="login" class="btn btn-info btn-md" value="login">
                                <input type="submit" name="register" class="btn btn-info btn-md" value="register">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
</body>
</html>


