<?php
session_start();
require_once "includes/dbh.inc.php";
 
// Initialize $cartItems as an empty array
$cartItems = [];

// Check if the user is logged in and has a cart
if (isset($_SESSION['userId'])) {
    try {
        $userId = $_SESSION['userId'];
        
        // Get the user's cart
        $stmt = $pdo->prepare("SELECT cartId FROM cart WHERE id = :userId");
        $stmt->execute(['userId' => $userId]);
        $cart = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($cart) {
            // Fetch cart items
            $stmt = $pdo->prepare("SELECT p.id, p.prodName, p.price, p.image, ci.quantity 
                                   FROM cart_items ci
                                   JOIN products p ON ci.id = p.id
                                   WHERE ci.cartId = :cartId");
            $stmt->execute(['cartId' => $cart['cartId']]);
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } catch (PDOException $e) {
        // Log the error and continue with an empty cart
        error_log("Error fetching cart items: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website design</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link rel="stylesheet" href="style.css">

   

</head>
<body>
    
<header class="header">
<a href="#" class ="logo">
<img src="image/truck.png" alt="">

</a>

<nav class="navbar">

    <a href="#homepage">home</a>
    <a href="#about">about</a>
    <a href="#products">products</a>
    <a href="#services">services</a>
    <a href="#contactus">contact</a>

    <a href="signup.php" id="signup-btn" title="Sign Up">
        <div class="fas fa-user-plus"></div>
    </a>

    
</nav>

        <div class="icon">
     
        <div class="fas fa-shopping-cart" id="cart-btn"></div>
        
        <div class="fas fa-bars" id="menu-btn"></div>


       

    <div class="search-form">
        <input type="search" id="search-box" placeholder="search here....">
        <label for="search-box" class="fas fa-search"></label>
    </div>
    </div>
    
    

    <div class="cart-items-container">
    <h2>Cart</h2>
    <?php if (empty($cartItems)): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <?php foreach ($cartItems as $item): ?>
            <div class="cart-item">
                <div class="image">
                    <img src="image/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['prodName']); ?>">
                </div>
                <div class="content">
                    <h3><?php echo htmlspecialchars($item['prodName']); ?></h3>
                    <div class="price">R<?php echo htmlspecialchars($item['price']); ?></div>
                    <div class="quantity">Quantity: <?php echo htmlspecialchars($item['quantity']); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
       
    <?php endif; ?>
    <a href="#" class="btn">Checkout</a>
</div>


</header>



<section class="homepage" id="homepage">

<div class="infoforpage">
    <h3>Tough Brakes</h3>
    <p>Est 2004</p>
    <a href="#products"class=btn>Order now</a>
</div>
</section>



<section class="about" id="about">

    <h1 class="heading"> <span>
        about
    </span>
    us
</h1>
<div class="row">
    <div class="image">
        <img src="image/mechanic.jpg" alt="">
    </div>
    <div class="info">
        <h3>Who are we</h3>
        <p>Founded in 2004 by owner and managing director Mike Letang, Tough Brakes is a proudly black-owned enterprise with a Level 1 BEE rating. Since our inception, we have established ourselves as significant players in the brake and clutch industry. Download our BEE Accreditation Certificate.

            Our team of mechanics and sales staff boasts a combined 40 years of experience, setting us apart from our competitors. Guided by Mike's personal motto, "We believe in combining quality workmanship with dedicated service," we are committed to excellence.
            
            Tough Brakes offers an extensive range of locally and internationally manufactured brake and clutch spares, ensuring you find the right parts for your needs. We supply a wide array of products for all sizes of commercial vehicles</p>
                
    </div>

</div>
</section>
  <!-- Products section -->

<section class="products" id="products">
    <h1 class="heading">Our Products</h1>
    <div class="products-container">
        <?php
        // Include database connection
        require_once "includes/dbh.inc.php";

        try {
            // Fetch products from the database
            $query = "SELECT * FROM products";
            $stmt = $pdo->query($query);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display products
            foreach ($products as $product) {
                // Define the image path for each product
                $imagePath = "image/" . $product['image'];
                ?>
                <div class="product">
                    <div class="image">
                        <!-- Check if the image file exists before displaying -->
                        <?php 
                        if (file_exists($imagePath)) {
                            echo "<img src=\"$imagePath\" alt=\"{$product['prodName']}\">";
                        } else {
                            echo "Image not found: $imagePath";
                        }
                        ?>
                    </div>
                    <h3><?php echo htmlspecialchars($product['prodName']); ?></h3>
                    <div class="price">R<?php echo htmlspecialchars($product['price']); ?></div>
                    <p><?php echo htmlspecialchars($product['prodDesc']); ?></p>
                    <button class="btn add-to-cart" data-id="<?php echo $product['id']; ?>">Add to Cart</button>
                </div>
                <?php
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
    </div>
</section>






 
    
            
  <!-- Services section -->

<section class="services" id="services">
<h1 class="heading">Our Services</h1>
<div class="box-container">
    
    <div class="box">
        <!-- add picture of service stuff -->
        <img src="image/truck.png" alt="" class="serve">
        <h3>Parts Collection and Delivery</h3>
        <p>We offer a convenient parts collection and delivery service to your depot.</p>
        

    </div>
    <div class="box">
        <!-- add picture of service stuff -->
        <img src="image/truck.png" alt="" class="serve">
        <h3>No Extra Cost for After-Hours Service</h3>
        <p>Enjoy our after-hours service without any additional charges.</p>
        

    </div>
    <div class="box">
        <!-- add picture of service stuff -->
        <img src="image/truck.png" alt="" class="serve">
        <h3>Exchange Program for Brake Drums and Shoes</h3>
        <p>We provide an exchange program for brake drums and shoes for most trucks, trailers, and buses.</p>
        

    </div>
    <div class="box">
        <!-- add picture of service stuff -->
        <img src="image/truck.png" alt="" class="serve">
        <h3>Professional Technical Advice</h3>
        <p>Receive expert technical advice from our experienced team.





        </p>
        

    </div>


</div>
</section>
   <!-- Contact Us section -->
<section class="contactus" id="contactus">
<h1 class="heading">Find us </h1>
<div class="row">
    <iframe class="googlemap" src="https://www.google.com/maps/embed?pb=!4v1716229510395!6m8!1m7!1sqWgNW2Hln51IBwIiSNdjWg!2m2!1d-26.17751692757475!2d27.93011288052044!3f348.02713334599156!4f11.238879231606333!5f0.7820865974627469" 
    width="600" height="450" style="border:0;" 
    allowfullscreen="" loading="lazy" ></iframe>

    
        
        


</section>





    <script src="script.js"></script>
</body>
</html>
