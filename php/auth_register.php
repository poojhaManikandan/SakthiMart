<?php
// ============================================================
// SakthiMart — php/auth_register.php
// POST: full_name, email, phone, password, confirm_password
// ============================================================
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../register.php');
    exit;
}

$full_name        = trim($_POST['full_name']        ?? '');
$email            = trim($_POST['email']            ?? '');
$phone            = trim($_POST['phone']            ?? '');
$password         = trim($_POST['password']         ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');

$errors = [];

if ($full_name === '') $errors[] = 'Full name is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
if (strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';
if ($password !== $confirm_password) $errors[] = 'Passwords do not match.';

if (empty($errors)) {
    $db = getDB();

    // Check duplicate email
    $stmt = $db->prepare("SELECT id FROM users WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        $errors[] = 'An account with this email already exists. Please log in.';
    }
}

if (!empty($errors)) {
    $_SESSION['auth_errors']        = $errors;
    $_SESSION['auth_old_name']      = $full_name;
    $_SESSION['auth_old_email']     = $email;
    $_SESSION['auth_old_phone']     = $phone;
    header('Location: ../register.php');
    exit;
}

// Hash password and insert
$hashed  = password_hash($password, PASSWORD_BCRYPT);
$db      = getDB();
$stmt    = $db->prepare(
    "INSERT INTO users (full_name, email, phone, password) VALUES (:name, :email, :phone, :password)"
);
$stmt->execute([
    ':name'     => $full_name,
    ':email'    => $email,
    ':phone'    => $phone === '' ? null : $phone,
    ':password' => $hashed,
]);

$user_id = $db->lastInsertId();

// Auto login after registration
$_SESSION['user_id']    = $user_id;
$_SESSION['user_name']  = $full_name;
$_SESSION['user_email'] = $email;

$_SESSION['auth_success'] = 'Welcome to SakthiMart, ' . $full_name . '! 🎉';
header('Location: ../index.php');
exit;
