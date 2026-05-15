<?php
// ============================================================
// SakthiMart — php/auth_login.php
// POST: email, password  →  sets session, redirects
// ============================================================
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit;
}

$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');
$redirect = trim($_POST['redirect'] ?? '../index.php');

$errors = [];

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Please enter a valid email address.';
} elseif ($password === '') {
    $errors[] = 'Password is required.';
} else {
    $db   = getDB();
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password'])) {
        $errors[] = 'Invalid email or password.';
    } else {
        // Success — set session
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_email']= $user['email'];

        header('Location: ' . $redirect);
        exit;
    }
}

// If errors — redirect back with error message in session
$_SESSION['auth_errors']    = $errors;
$_SESSION['auth_old_email'] = $email;
header('Location: ../login.php');
exit;
