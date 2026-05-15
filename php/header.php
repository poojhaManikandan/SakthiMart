<?php
// ============================================================
// SakthiMart — php/header.php
// Reusable navbar — include at top of every page
// Usage: $pageTitle = 'Home'; require 'php/header.php';
// ============================================================
ini_set('display_errors', 0);
error_reporting(0);
if (session_status() === PHP_SESSION_NONE) session_start();

$isLoggedIn  = isset($_SESSION['user_id']);
$userName    = ($isLoggedIn && isset($_SESSION['user_name'])) ? explode(' ', $_SESSION['user_name'])[0] : null; // First name only

// Pop one-time flash messages
$authSuccess = isset($_SESSION['auth_success']) ? $_SESSION['auth_success'] : null;
if (isset($_SESSION['auth_success'])) {
    unset($_SESSION['auth_success']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($metaDesc ?? 'SakthiMart - Your Premium Shopping Hub') ?>">
    <title><?= htmlspecialchars($pageTitle ?? 'SakthiMart') ?> | SakthiMart</title>
    <link rel="stylesheet" href="<?= $cssPath ?? '' ?>style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<?php if (isset($authSuccess) && $authSuccess): ?>
<!-- Flash message shown via JS toast on load -->
<script>
    window.__flashSuccess = <?= json_encode($authSuccess) ?>;
</script>
<?php endif; ?>

<header>
    <nav class="navbar">
        <div class="nav-logo" onclick="window.location.href='<?= $cssPath ?? '' ?>index.php'">SakthiMart</div>

        <div class="nav-search">
            <input type="text" id="search-input" placeholder="Search for electronics, fashion, books...">
            <button id="search-btn">Search</button>
        </div>

        <div class="nav-items">

            <?php if (isset($isLoggedIn) && $isLoggedIn): ?>
            <!-- ── Logged-in user ── -->
            <div class="nav-link">
                <span class="link-1"><i class="fa-solid fa-user"></i> Hello, <?= htmlspecialchars($userName) ?></span>
                <a href="<?= $cssPath ?? '' ?>php/logout.php" class="link-2" title="Sign Out">Sign Out</a>
            </div>

            <?php else: ?>
            <!-- ── Guest links ── -->
            <div class="nav-link" onclick="window.location.href='<?= $cssPath ?? '' ?>login.php'" style="cursor:pointer;">
                <span class="link-1"><i class="fa-solid fa-user"></i> Hello, Sign in</span>
                <span class="link-2">Account &amp; Lists</span>
            </div>
            <?php endif; ?>

            <div class="nav-link" onclick="window.location.href='<?= $cssPath ?? '' ?>orders.php'" style="cursor:pointer;">
                <span class="link-1"><i class="fa-solid fa-rotate-left"></i> Returns</span>
                <span class="link-2">&amp; Orders</span>
            </div>

            <div class="nav-link cart-link" style="cursor:pointer;" title="View Cart" onclick="window.location.href='<?= $cssPath ?? '' ?>cart.php'">
                <div class="cart-icon-container">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="cart-count">0</span>
                </div>
                <span class="link-2">Cart</span>
            </div>
        </div>
    </nav>

    <div class="sub-nav">
        <a href="<?= $cssPath ?? '' ?>index.php"><span>Home</span></a>
        <a href="<?= $cssPath ?? '' ?>products.php"><span>Products</span></a>
        <a href="<?= $cssPath ?? '' ?>contact.php"><span>Contact Us</span></a>
        <a href="<?= $cssPath ?? '' ?>products.php?category=Best Sellers"><span>Best Sellers</span></a>
        <a href="<?= $cssPath ?? '' ?>products.php?category=Electronics"><span>Electronics</span></a>
    </div>
</header>
