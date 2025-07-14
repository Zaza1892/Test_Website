<?php
session_start();
require_once "dbh.inc.php";

// get items from sql 
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
// Add to cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"])) {
    $product_id = $_POST["product_id"];
    $product = null;

    // find product 
    foreach ($products as $prod) {
        if ($prod['prodId'] == $product_id) {
            $product = $prod;
            break;
        }
    }

    // add to cart when found 
    if ($product) {
        $cart_item = [
            "id" => $product["prodId"],
            "prodName" => $product["prodName"],
            "price" => $product["price"],
            "quantity" => 1,
            "image" => $product["image"]
        ];

        if (isset($_SESSION["cart"])) {
            $is_in_cart = false;

            //check if in cart 
            foreach ($_SESSION["cart"] as &$item) {
                if ($item["id"] == $product["prodId"]) {
                    $item["quantity"]++;
                    $is_in_cart = true;
                    break;
                }
            }

            // add if empty
            if (!$is_in_cart) {
                $_SESSION["cart"][] = $cart_item;
            }
        } else {
            // empty
            $_SESSION["cart"] = [$cart_item];
        }
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
        <div class="cart-items-container">
            <?php if (isset($_SESSION["cart"])): ?>
                <?php foreach ($_SESSION["cart"] as $item): ?>
                    <div class="cart-items">
                        <span class="fas fa-times"></span>
                        <img src="<?php echo $item['image']; ?>" alt="">
                        <div class="content">
                            <h3><?php echo $item['prodName']; ?></h3>
                            <div class="price">R<?php echo $item['price']; ?></div>
                            <div class="quantity">Quantity: <?php echo $item['quantity']; ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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
