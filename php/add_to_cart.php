<?php
// ============================================================
// SakthiMart — API: Add to Cart
// POST /php/add_to_cart.php
// Body: product_id, name, price, image_url
// ============================================================
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$product_id = intval($_POST['product_id'] ?? 0);
$name       = trim($_POST['name']        ?? '');
$price      = floatval($_POST['price']   ?? 0);
$image_url  = trim($_POST['image_url']   ?? '');

if ($product_id <= 0 || $name === '') {
    echo json_encode(['error' => 'Invalid product data']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'auth', 'message' => 'You must sign in to add items to your cart.']);
    exit;
}

// Initialise cart in session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// If product already in cart, increment qty
if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]['qty']++;
} else {
    $_SESSION['cart'][$product_id] = [
        'product_id' => $product_id,
        'name'       => $name,
        'price'      => $price,
        'image_url'  => $image_url,
        'qty'        => 1,
    ];
}

$total_items = array_sum(array_column($_SESSION['cart'], 'qty'));

echo json_encode([
    'success'     => true,
    'message'     => 'Item added to cart!',
    'cart_count'  => $total_items,
]);
