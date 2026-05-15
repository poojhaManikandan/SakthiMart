<?php
// ============================================================
// SakthiMart — php/logout.php
// Destroys session and redirects to home
// ============================================================
require_once 'db.php';

// Clear only auth + cart session data
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_email']);
unset($_SESSION['cart']);

session_destroy();
header('Location: ../index.php');
exit;
