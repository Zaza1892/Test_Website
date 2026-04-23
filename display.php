<?php
session_start();
require_once "dbh.inc.php";

// get items from sql 
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


$cartItems = [];

if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];

    $stmt = $pdo->prepare("SELECT cartId FROM cart WHERE id = :userId");
    $stmt->execute(['userId' => $userId]);
    $cart = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cart) {
        $stmt = $pdo->prepare("
            SELECT p.id, p.prodName, p.price, p.image, ci.quantity 
            FROM cart_items ci
            JOIN products p ON ci.id = p.id
            WHERE ci.cartId = :cartId
        ");

        $stmt->execute(['cartId' => $cart['cartId']]);
        $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <a href="#" class="logo">
            <img src="image/truck.png" alt="Logo">
        </a>
        <nav class="navbar">
            <a href="#homepage">Home</a>
            <a href="#about">About</a>
            <a href="#products">Products</a>
            <a href="#services">Services</a>
            <a href="#contactus">Contact</a>
            <a href="signup.html" id="signup-btn" title="Sign Up">
                <div class="fas fa-user-plus"></div>
            </a>
        </nav>
        <div class="icon">
            <div class="fas fa-search" id="search-btn"></div>
            <div class="fas fa-shopping-cart" id="cart-btn"></div>
            <div class="fas fa-bars" id="menu-btn"></div>
            <div class="search-form">
                <input type="search" id="search-box" placeholder="search here....">
                <label for="search-box" class="fas fa-search"></label>
            </div>
        </div>
        
            <a href="checkout.php" class="btn">Checkout</a>
        </div>
    </header>

    <section class="parts" id="products">
        <h1 class="heading">Products</h1>
        <div class="box-container">
            <?php foreach ($products as $product): ?>
                <div class="box">
                    <div class="icons">
                        <form action="display_product.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['prodId']; ?>">
                            <button type="submit" class="fas fa-shopping-cart"></button>
                        </form>
                        <a href="#" class="fas fa-eye"></a>
                    </div>
                    <div class="image">
                        <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['prodName']; ?>">
                    </div>
                    <h3><?php echo $product['prodName']; ?></h3>
                    <div class="price">R<?php echo $product['price']; ?></div>
                    <a href="#" class="btn">Add to Cart</a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <script src="script.js"></script>
</body>
</html>
