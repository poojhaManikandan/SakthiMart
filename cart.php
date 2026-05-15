<?php
// ============================================================
// SakthiMart — cart.php (Shopping Cart Page)
// ============================================================
$pageTitle = 'Shopping Cart';
$metaDesc  = 'SakthiMart Shopping Cart - Review your selected items and proceed to checkout.';
require_once 'php/header.php';
?>

    <style>
        .cart-page-section {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        #cart-items-container {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .cart-item {
            background: white;
            border: 1px solid #ddd;
            border-radius: var(--radius);
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: var(--shadow);
            transition: 0.2s;
        }

        .cart-item:hover { box-shadow: 0 6px 18px rgba(0,0,0,0.12); }

        .cart-item img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .cart-item-info { flex: 1; }
        .cart-item-name { font-weight: 600; font-size: 15px; margin-bottom: 6px; }
        .cart-item-price { font-size: 14px; color: #555; }

        .cart-item-controls { display: flex; align-items: center; gap: 10px; }

        .qty-btn {
            width: 30px; height: 30px;
            border: 1px solid #ccc;
            border-radius: 50%;
            background: #f3f3f3;
            cursor: pointer;
            font-size: 18px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            transition: 0.2s;
        }

        .qty-btn:hover { background: var(--amazon-orange); border-color: var(--amazon-orange); }
        .cart-item-qty { font-size: 16px; font-weight: 700; min-width: 24px; text-align: center; }
        .cart-item-subtotal { font-size: 18px; font-weight: 700; color: var(--price-color); min-width: 90px; text-align: right; }

        .remove-item-btn {
            background: none; border: none; cursor: pointer;
            color: #aaa; font-size: 16px; padding: 6px; transition: 0.2s;
        }
        .remove-item-btn:hover { color: #B12704; }

        .cart-summary {
            background: white; border: 1px solid #ddd;
            border-radius: var(--radius); padding: 24px;
            margin-top: 24px;
            display: flex; justify-content: space-between; align-items: center;
            box-shadow: var(--shadow);
        }

        .cart-total-label { font-size: 20px; font-weight: 600; }
        #cart-grand-total { font-size: 28px; font-weight: 700; color: var(--price-color); }

        .checkout-btn {
            background-color: var(--amazon-orange);
            color: var(--text-dark);
            padding: 12px 32px;
            border: none; border-radius: 25px;
            font-size: 16px; font-weight: 700;
            cursor: pointer; transition: 0.3s;
        }
        .checkout-btn:hover { background-color: var(--amazon-orange-hover); transform: translateY(-2px); }

        .empty-cart {
            text-align: center; padding: 60px 20px;
            background: white; border-radius: var(--radius);
            border: 1px solid #ddd;
            display: flex; flex-direction: column; align-items: center;
        }
        .empty-cart h2 { font-size: 24px; margin-bottom: 10px; }
        .empty-cart p { color: #777; margin-bottom: 20px; }

        @media (max-width: 600px) {
            .cart-item { flex-wrap: wrap; }
            .cart-summary { flex-direction: column; gap: 16px; text-align: center; }
        }
    </style>

    <main>
        <section class="page-header"
            style="background-color: var(--amazon-light); color: white; padding: 40px 20px; text-align: center;">
            <h1><i class="fa-solid fa-cart-shopping" style="margin-right:12px;"></i>Your Shopping Cart</h1>
            <p>Review your items and proceed when ready.</p>
        </section>

        <section class="cart-page-section">
            <div id="cart-items-container">
                <div style="padding:30px; text-align:center; color:#555;">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size:30px;color:#febd69;"></i>
                    <p style="margin-top:10px;">Loading your cart...</p>
                </div>
            </div>

            <div class="cart-summary" id="cart-summary" style="display:none;">
                <div>
                    <span class="cart-total-label">Grand Total: </span>
                    <span id="cart-grand-total">₹0</span>
                </div>
                <button class="checkout-btn" onclick="window.location.href='checkout.php'">
                    <i class="fa-solid fa-lock" style="margin-right:8px;"></i>Proceed to Checkout
                </button>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">Back to top</div>
        <div class="footer-content">
            <div class="footer-column"><h3>Get to Know Us</h3><ul><li>About Us</li><li>Careers</li><li>Press Releases</li><li>SakthiMart Science</li></ul></div>
            <div class="footer-column"><h3>Connect with Us</h3><ul><li>Facebook</li><li>Twitter</li><li>Instagram</li></ul></div>
            <div class="footer-column"><h3>Make Money with Us</h3><ul><li>Sell on SakthiMart</li><li>Protect and Build Your Brand</li><li>Become an Affiliate</li><li>Advertise Your Products</li></ul></div>
            <div class="footer-column"><h3>Let Us Help You</h3><ul><li>Your Account</li><li>Returns Centre</li><li>100% Purchase Protection</li><li>SakthiMart App Download</li><li>Help</li></ul></div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(function() {
            var observer = new MutationObserver(function() {
                if ($('#cart-items-container .cart-item').length > 0) {
                    $('#cart-summary').show();
                } else {
                    $('#cart-summary').hide();
                }
            });
            observer.observe($('#cart-items-container')[0], { childList: true, subtree: true });
        });
    </script>

</body>
</html>
