<?php
// ============================================================
// SakthiMart — API: Remove from Cart
// POST /php/remove_from_cart.php
// Body: product_id
// ============================================================
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$product_id = intval($_POST['product_id'] ?? 0);

if ($product_id <= 0) {
    echo json_encode(['error' => 'Invalid product id']);
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$force = intval($_POST['force'] ?? 0);

if (isset($_SESSION['cart'][$product_id])) {
    if ($force || $_SESSION['cart'][$product_id]['qty'] <= 1) {
        // Force remove or last item — delete entirely
        unset($_SESSION['cart'][$product_id]);
    } else {
        // Just decrement qty
        $_SESSION['cart'][$product_id]['qty']--;
    }
}

$total_items = array_sum(array_column($_SESSION['cart'], 'qty'));

echo json_encode([
    'success'    => true,
    'message'    => 'Item removed',
    'cart_count' => $total_items,
]);
