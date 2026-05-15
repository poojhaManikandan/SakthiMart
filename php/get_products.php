<?php
// ============================================================
// SakthiMart — API: Get Products
// GET /php/get_products.php
// Query params: ?search=keyword  &category=Electronics
// ============================================================
require_once 'db.php';
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$db     = getDB();
$search = isset($_GET['search'])   ? trim($_GET['search'])   : '';
$cat    = isset($_GET['category']) ? trim($_GET['category']) : '';

$sql    = "SELECT * FROM products WHERE 1=1";
$params = [];

if ($search !== '') {
    $sql     .= " AND name LIKE :search";
    $params[':search'] = '%' . $search . '%';
}

if ($cat !== '' && $cat !== 'All') {
    $sql     .= " AND category = :category";
    $params[':category'] = $cat;
}

$sql .= " ORDER BY id ASC";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll();

// Format price as Indian currency string
foreach ($products as &$p) {
    $p['price_formatted'] = '₹' . number_format($p['price'], 0, '.', ',');
    $p['stars']           = buildStars((float)$p['rating']);
}

echo json_encode(['success' => true, 'products' => $products]);

function buildStars(float $rating): string {
    $full  = floor($rating);
    $half  = ($rating - $full) >= 0.5 ? 1 : 0;
    $empty = 5 - $full - $half;
    return str_repeat('★', $full) . str_repeat('½', $half) . str_repeat('☆', $empty);
}
