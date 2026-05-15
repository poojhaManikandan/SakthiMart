<?php
// ============================================================
// SakthiMart — register.php
// ============================================================
require_once 'php/db.php';

// Already logged in? Redirect home
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$errors  = $_SESSION['auth_errors']    ?? [];
$oldName = $_SESSION['auth_old_name']  ?? '';
$oldEmail= $_SESSION['auth_old_email'] ?? '';
$oldPhone= $_SESSION['auth_old_phone'] ?? '';
unset($_SESSION['auth_errors'], $_SESSION['auth_old_name'], $_SESSION['auth_old_email'], $_SESSION['auth_old_phone']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Create a free SakthiMart account to start shopping today.">
    <title>SakthiMart | Create Account</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
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
            max-width: 440px;
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

        /* Password strength bar */
        .pw-strength-bar {
            height: 4px;
            border-radius: 2px;
            margin-top: 6px;
            transition: all 0.3s;
            background: #ddd;
        }

        .pw-strength-label {
            font-size: 11px;
            margin-top: 3px;
            color: #777;
        }

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

        .auth-submit-btn:hover { background: var(--amazon-orange-hover); }

        .auth-alt-link {
            display: block;
            text-align: center;
            margin-top: 18px;
            font-size: 13px;
            color: #007185;
            text-decoration: none;
        }

        .auth-alt-link:hover { text-decoration: underline; color: #c45500; }

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

        .field-hint {
            font-size: 12px;
            color: #888;
            margin-top: 4px;
        }

        .terms-note {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 16px;
            line-height: 1.6;
        }

        .terms-note a { color: #007185; }
        .terms-note a:hover { text-decoration: underline; }

        .signin-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .signin-link a { color: #007185; font-weight: 600; }
        .signin-link a:hover { text-decoration: underline; }

        .auth-footer-bar {
            background: var(--amazon-light);
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #aaa;
        }

        .auth-footer-bar a { color: #febd69; margin: 0 8px; }
        .auth-footer-bar a:hover { text-decoration: underline; }

        /* Input match indicator */
        .match-ok  { border-color: #007600 !important; }
        .match-err { border-color: #B12704 !important; }
    </style>
</head>
<body>

<div class="auth-page">

    <div class="auth-logo">
        <a href="index.php">SakthiMart</a>
    </div>

    <div class="auth-main">
        <div class="auth-card">
            <h1>Create Account</h1>

            <?php if (!empty($errors)): ?>
            <div class="auth-errors">
                <?php foreach ($errors as $e): ?>
                <p><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($e) ?></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <form class="auth-form" action="php/auth_register.php" method="POST" id="register-form">

                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name"
                           placeholder="Poojha Sakthi"
                           value="<?= htmlspecialchars($oldName) ?>" required autofocus>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email"
                           placeholder="you@example.com"
                           value="<?= htmlspecialchars($oldEmail) ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Mobile Number <span style="font-weight:400;color:#888;">(Optional)</span></label>
                    <input type="tel" id="phone" name="phone"
                           placeholder="+91 98765 43210"
                           value="<?= htmlspecialchars($oldPhone) ?>">
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password"
                               placeholder="At least 6 characters" required>
                        <span class="toggle-pw" id="toggle-pw1"><i class="fa-solid fa-eye"></i></span>
                    </div>
                    <div class="pw-strength-bar" id="pw-strength-bar"></div>
                    <div class="pw-strength-label" id="pw-strength-label"></div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Re-enter Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="confirm_password" name="confirm_password"
                               placeholder="Repeat your password" required>
                        <span class="toggle-pw" id="toggle-pw2"><i class="fa-solid fa-eye"></i></span>
                    </div>
                    <div class="field-hint" id="confirm-hint"></div>
                </div>

                <button type="submit" class="auth-submit-btn" id="register-btn">
                    <i class="fa-solid fa-user-plus" style="margin-right:6px;"></i> Create Account
                </button>

                <p class="terms-note">
                    By creating an account, you agree to SakthiMart's
                    <a href="#">Conditions of Use</a> and
                    <a href="#">Privacy Notice</a>.
                </p>
            </form>

            <div class="signin-link">
                Already have an account? <a href="login.php">Sign In</a>
            </div>

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
    // ── Toggle password visibility ──
    $('#toggle-pw1').on('click', function() {
        var $i = $('#password');
        $i.attr('type', $i.attr('type') === 'password' ? 'text' : 'password');
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });
    $('#toggle-pw2').on('click', function() {
        var $i = $('#confirm_password');
        $i.attr('type', $i.attr('type') === 'password' ? 'text' : 'password');
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    // ── Password strength ──
    $('#password').on('input', function() {
        var pw  = $(this).val();
        var len = pw.length;
        var bar = $('#pw-strength-bar');
        var lbl = $('#pw-strength-label');
        var score = 0;
        if (len >= 6)  score++;
        if (len >= 10) score++;
        if (/[A-Z]/.test(pw)) score++;
        if (/[0-9]/.test(pw)) score++;
        if (/[^A-Za-z0-9]/.test(pw)) score++;

        var colors = ['#ddd','#B12704','#e77600','#febd69','#007600','#007600'];
        var labels = ['','Weak','Fair','Good','Strong','Very Strong'];
        bar.css({ width: (score * 20) + '%', background: colors[score] });
        lbl.text(len > 0 ? labels[score] : '').css('color', colors[score]);
    });

    // ── Confirm password match ──
    function checkMatch() {
        var pw  = $('#password').val();
        var cpw = $('#confirm_password').val();
        var $c  = $('#confirm_password');
        var $h  = $('#confirm-hint');
        if (cpw === '') { $c.removeClass('match-ok match-err'); $h.text(''); return; }
        if (pw === cpw) {
            $c.removeClass('match-err').addClass('match-ok');
            $h.text('✓ Passwords match').css('color','#007600');
        } else {
            $c.removeClass('match-ok').addClass('match-err');
            $h.text('✕ Passwords do not match').css('color','#B12704');
        }
    }
    $('#password, #confirm_password').on('input', checkMatch);

    // ── Loading state on submit ──
    $('#register-form').on('submit', function() {
        var pw  = $('#password').val();
        var cpw = $('#confirm_password').val();
        if (pw !== cpw) {
            alert('Passwords do not match!');
            return false;
        }
        var $btn = $('#register-btn');
        $btn.html('<i class="fa-solid fa-spinner fa-spin"></i> Creating account...');
        setTimeout(function() {
            $btn.prop('disabled', true);
        }, 10);
    });
});
</script>

</body>
</html>
