<?php
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/path/to/error.log'); 

try {
    require_once 'includes/dbh.inc.php';
    session_start();
 
    

    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['productId'])) {
        throw new Exception('Product ID not provided');
    }

    $productId = $data['productId'];
    $userId = $_SESSION['userId'];

    // Check if a cart exists for this user, if not create one
    $stmt = $pdo->prepare("SELECT cartId FROM cart WHERE id = :userId");
    $stmt->execute(['userId' => $userId]);
    $cart = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cart) {
        $stmt = $pdo->prepare("INSERT INTO cart (id, created_at) VALUES (:userId, NOW())");
        $stmt->execute(['userId' => $userId]);
        $cartId = $pdo->lastInsertId();
    } else {
        $cartId = $cart['cartId'];
    }

    // Add item to cart_items
    $stmt = $pdo->prepare("INSERT INTO cart_items (cartId, id, quantity) 
                           VALUES (:cartId, :productId, 1)
                           ON DUPLICATE KEY UPDATE quantity = quantity + 1");
    $stmt->execute(['cartId' => $cartId, 'productId' => $productId]);

    // Fetch updated cart items
    $stmt = $pdo->prepare("SELECT p.id, p.prodName, p.price, p.image, ci.quantity 
                           FROM cart_items ci
                           JOIN products p ON ci.id = p.id
                           WHERE ci.cartId = :cartId");
    $stmt->execute(['cartId' => $cartId]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'cartItems' => $cartItems]);

} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['success' => false, 'message' => 'An unexpected error occurred: ' . $e->getMessage()]);
}
?>
