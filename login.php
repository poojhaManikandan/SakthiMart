<?php
// ============================================================
// SakthiMart — login.php
// ============================================================
require_once 'php/db.php';

// Already logged in? Redirect home
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$errors   = $_SESSION['auth_errors']    ?? [];
$oldEmail = $_SESSION['auth_old_email'] ?? '';
unset($_SESSION['auth_errors'], $_SESSION['auth_old_email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sign in to your SakthiMart account to shop, track orders, and manage your profile.">
    <title>SakthiMart | Sign In</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Auth page layout */
        .auth-page {
            min-height: 100vh;
            background: var(--bg-light);
            display: flex;
            flex-direction: column;
        }

        .auth-logo {
            background: var(--amazon-dark);
            text-align: center;
            padding: 16px;
        }

        .auth-logo a {
            font-size: 28px;
            font-weight: 800;
            color: var(--amazon-orange);
            font-family: 'Inter', sans-serif;
            text-decoration: none;
        }

        .auth-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .auth-card {
            background: white;
            border: 1px solid #ccc;
            border-radius: var(--radius);
            padding: 32px 36px;
            width: 100%;
            max-width: 400px;
            box-shadow: var(--shadow);
        }

        .auth-card h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 24px;
            color: var(--text-dark);
        }

        .auth-form .form-group {
            margin-bottom: 18px;
        }

        .auth-form label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .auth-form input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: 0.25s;
            outline: none;
        }

        .auth-form input:focus {
            border-color: var(--amazon-orange);
            box-shadow: 0 0 0 3px rgba(254, 189, 105, 0.3);
        }

        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 42px;
        }

        .toggle-pw {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
            font-size: 15px;
        }

        .toggle-pw:hover { color: var(--amazon-dark); }

        .auth-submit-btn {
            width: 100%;
            background: var(--amazon-orange);
            border: none;
            padding: 12px;
            border-radius: 4px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.25s;
            font-family: 'Inter', sans-serif;
            margin-top: 6px;
        }

        .auth-submit-btn:hover {
            background: var(--amazon-orange-hover);
        }

        .auth-divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
            color: #aaa;
            font-size: 13px;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #ddd;
        }

        .auth-alt-btn {
            width: 100%;
            background: white;
            border: 1px solid #ccc;
            padding: 11px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.25s;
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
        }

        .auth-alt-btn:hover {
            background: var(--bg-light);
            border-color: var(--amazon-orange);
        }

        .auth-alt-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 13px;
            color: #007185;
            text-decoration: none;
        }

        .auth-alt-link:hover { text-decoration: underline; color: #c45500; }

        /* Error alert */
        .auth-errors {
            background: #fff8f7;
            border: 1px solid #e77600;
            border-left: 4px solid #B12704;
            border-radius: 4px;
            padding: 12px 16px;
            margin-bottom: 18px;
        }

        .auth-errors p {
            color: #B12704;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .auth-errors p:last-child { margin-bottom: 0; }

        .auth-footer-bar {
            background: var(--amazon-light);
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #aaa;
        }

        .auth-footer-bar a { color: #febd69; margin: 0 8px; }
        .auth-footer-bar a:hover { text-decoration: underline; }

        .terms-note {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 16px;
            line-height: 1.6;
        }

        .terms-note a { color: #007185; }
        .terms-note a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="auth-page">

    <!-- Logo Bar -->
    <div class="auth-logo">
        <a href="index.php">SakthiMart</a>
    </div>

    <div class="auth-main">
        <div class="auth-card">
            <h1>Sign In</h1>

            <?php if (!empty($errors)): ?>
            <div class="auth-errors">
                <?php foreach ($errors as $e): ?>
                <p><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($e) ?></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <form class="auth-form" action="php/auth_login.php" method="POST">
                <input type="hidden" name="redirect" value="../index.php">

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                           placeholder="you@example.com"
                           value="<?= htmlspecialchars($oldEmail) ?>" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password"
                               placeholder="Enter your password" required>
                        <span class="toggle-pw" id="toggle-pw" title="Show/Hide password">
                            <i class="fa-solid fa-eye"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="auth-submit-btn" id="login-btn">
                    <i class="fa-solid fa-right-to-bracket" style="margin-right:6px;"></i> Sign In
                </button>
            </form>

            <div class="auth-divider">New to SakthiMart?</div>

            <button class="auth-alt-btn" onclick="window.location.href='register.php'">
                <i class="fa-solid fa-user-plus" style="margin-right:6px;"></i> Create your SakthiMart account
            </button>

            <p class="terms-note">
                By signing in, you agree to SakthiMart's
                <a href="#">Conditions of Use</a> and
                <a href="#">Privacy Notice</a>.
            </p>

            <a href="index.php" class="auth-alt-link">
                <i class="fa-solid fa-arrow-left" style="margin-right:4px;"></i> Back to Home
            </a>
        </div>
    </div>

    <div class="auth-footer-bar">
        <a href="#">Conditions of Use</a>
        <a href="#">Privacy Notice</a>
        <a href="contact.php">Help</a>
        <br><br>
        &copy; <?= date('Y') ?> SakthiMart. All rights reserved.
    </div>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(function() {
    // Toggle password visibility
    $('#toggle-pw').on('click', function() {
        var $input = $('#password');
        var isHidden = $input.attr('type') === 'password';
        $input.attr('type', isHidden ? 'text' : 'password');
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    // Add loading state on submit
    $('form.auth-form').on('submit', function() {
        var $btn = $('#login-btn');
        $btn.html('<i class="fa-solid fa-spinner fa-spin"></i> Signing in...');
        setTimeout(function() {
            $btn.prop('disabled', true);
        }, 10);
    });
});
</script>

</body>
</html>
