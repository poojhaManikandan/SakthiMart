<?php
// ============================================================
// SakthiMart — API: Save Contact Form
// POST /php/contact_submit.php
// Body: full_name, email, order_id, message
// ============================================================
require_once 'db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$full_name = trim($_POST['full_name'] ?? '');
$email     = trim($_POST['email']     ?? '');
$order_id  = trim($_POST['order_id']  ?? '');
$message   = trim($_POST['message']   ?? '');

// Basic validation
$errors = [];
if ($full_name === '') $errors[] = 'Full name is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
if ($message === '') $errors[] = 'Message is required.';

if (!empty($errors)) {
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit;
}

try {
    $db   = getDB();
    $stmt = $db->prepare(
        "INSERT INTO contacts (full_name, email, order_id, message) VALUES (:name, :email, :order_id, :message)"
    );
    $stmt->execute([
        ':name'     => $full_name,
        ':email'    => $email,
        ':order_id' => $order_id === '' ? null : $order_id,
        ':message'  => $message,
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Thank you, ' . htmlspecialchars($full_name) . '! We\'ll get back to you soon.',
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'errors' => ['Server error. Please try again later.']]);
}
