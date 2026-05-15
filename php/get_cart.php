<?php
// ============================================================
// SakthiMart — API: Get Cart
// GET /php/get_cart.php
// Returns cart items and total count
// ============================================================
require_once 'db.php';
header('Content-Type: application/json');

$cart  = $_SESSION['cart'] ?? [];
$items = array_values($cart);
$total = array_sum(array_column($items, 'qty'));

// Calculate grand total price
$grand_total = 0;
foreach ($items as &$item) {
    $item['subtotal']          = $item['price'] * $item['qty'];
    $item['price_formatted']   = '₹' . number_format($item['price'], 0, '.', ',');
    $item['subtotal_formatted']= '₹' . number_format($item['subtotal'], 0, '.', ',');
    $grand_total              += $item['subtotal'];
}

echo json_encode([
    'success'               => true,
    'cart_count'            => $total,
    'items'                 => $items,
    'grand_total'           => $grand_total,
    'grand_total_formatted' => '₹' . number_format($grand_total, 0, '.', ','),
]);
