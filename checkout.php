<?php
// ============================================================
// SakthiMart — checkout.php (Dummy Checkout Page)
// ============================================================
$pageTitle = 'Secure Checkout';
require_once 'php/header.php';

// Ensure user is logged in
if (!isset($isLoggedIn) || !$isLoggedIn) {
    header('Location: login.php');
    exit;
}
?>
    <style>
        .checkout-page {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .checkout-section {
            background: white;
            border: 1px solid #ddd;
            border-radius: var(--radius);
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: var(--shadow);
        }

        .checkout-section h2 {
            font-size: 20px;
            margin-bottom: 16px;
            color: var(--amazon-dark);
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .form-row {
            display: flex;
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-col {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-col label {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .form-col input, .form-col select {
            padding: 10px 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: inherit;
        }

        .form-col input:focus, .form-col select:focus {
            border-color: var(--amazon-orange);
            outline: none;
            box-shadow: 0 0 0 3px rgba(254, 189, 105, 0.3);
        }

        .payment-options {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.2s;
        }

        .payment-option:hover {
            background: var(--bg-light);
        }

        .payment-option.active {
            border-color: var(--amazon-orange);
            background: #fff9f0;
        }

        .order-summary-box {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: var(--radius);
            padding: 24px;
            position: sticky;
            top: 20px;
        }

        .order-summary-box h2 {
            font-size: 18px;
            margin-bottom: 16px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: 700;
            color: var(--price-color);
            border-top: 1px solid #ddd;
            padding-top: 12px;
            margin-top: 12px;
        }

        .place-order-btn {
            width: 100%;
            background-color: var(--amazon-orange);
            border: none;
            padding: 14px;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 20px;
        }

        .place-order-btn:hover {
            background-color: var(--amazon-orange-hover);
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .checkout-page {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <main>
        <section class="page-header" style="background-color: var(--amazon-light); color: white; padding: 25px 20px; text-align: center;">
            <h1><i class="fa-solid fa-lock" style="margin-right:10px;"></i>Secure Checkout</h1>
        </section>

        <div class="checkout-page">
            <div class="checkout-forms">
                <!-- Shipping Address -->
                <div class="checkout-section">
                    <h2><i class="fa-solid fa-location-dot" style="margin-right:8px;color:var(--amazon-orange);"></i> 1. Shipping Address</h2>
                    <div class="form-row">
                        <div class="form-col">
                            <label>Full Name</label>
                            <input type="text" value="<?= htmlspecialchars($userName) ?>" placeholder="Poojha Sakthi">
                        </div>
                        <div class="form-col">
                            <label>Mobile Number</label>
                            <input type="text" placeholder="10-digit mobile number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-col">
                            <label>Pincode</label>
                            <input type="text" placeholder="6 digits [0-9] PIN code">
                        </div>
                        <div class="form-col">
                            <label>City</label>
                            <input type="text" placeholder="Chennai">
                        </div>
                    </div>
                    <div class="form-row" style="flex-direction: column;">
                        <div class="form-col">
                            <label>Flat, House no., Building, Company</label>
                            <input type="text" placeholder="Apartment details">
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="checkout-section">
                    <h2><i class="fa-solid fa-credit-card" style="margin-right:8px;color:var(--amazon-orange);"></i> 2. Payment Method</h2>
                    <div class="payment-options">
                        <label class="payment-option active">
                            <input type="radio" name="payment" checked>
                            <span>Credit / Debit Card</span>
                            <i class="fa-brands fa-cc-visa" style="margin-left:auto;font-size:20px;color:#1A1F71;"></i>
                            <i class="fa-brands fa-cc-mastercard" style="font-size:20px;color:#EB001B;"></i>
                        </label>
                        <div class="cc-form" style="padding: 10px 0 10px 30px;">
                            <div class="form-row">
                                <div class="form-col" style="flex:2;">
                                    <label>Card Number (Dummy)</label>
                                    <input type="text" placeholder="XXXX XXXX XXXX XXXX">
                                </div>
                                <div class="form-col" style="flex:1;">
                                    <label>Expiry</label>
                                    <input type="text" placeholder="MM/YY">
                                </div>
                                <div class="form-col" style="flex:1;">
                                    <label>CVV</label>
                                    <input type="password" placeholder="123">
                                </div>
                            </div>
                        </div>

                        <label class="payment-option">
                            <input type="radio" name="payment">
                            <span>UPI (Google Pay, PhonePe, Paytm)</span>
                            <i class="fa-solid fa-mobile-screen-button" style="margin-left:auto;color:#555;"></i>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment">
                            <span>Cash on Delivery (COD)</span>
                            <i class="fa-solid fa-money-bill-wave" style="margin-left:auto;color:#007600;"></i>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div>
                <div class="order-summary-box">
                    <h2>Order Summary</h2>
                    <div class="summary-row">
                        <span>Items (1):</span>
                        <span>₹14,999</span>
                    </div>
                    <div class="summary-row">
                        <span>Delivery:</span>
                        <span>₹40</span>
                    </div>
                    <div class="summary-row">
                        <span>Promotion Applied:</span>
                        <span style="color:var(--success);">-₹40</span>
                    </div>
                    <div class="summary-total">
                        <span>Order Total:</span>
                        <span>₹14,999</span>
                    </div>

                    <button class="place-order-btn" onclick="placeOrder()">Place Your Order</button>
                    <p style="font-size:12px; color:#777; margin-top:15px; text-align:center;">
                        By placing your order, you agree to SakthiMart's privacy notice and conditions of use.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Success Modal -->
    <div id="success-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.6); z-index:9999; align-items:center; justify-content:center;">
        <div style="background:white; padding:40px; border-radius:8px; text-align:center; max-width:400px;">
            <i class="fa-solid fa-circle-check" style="color:var(--success); font-size:60px; margin-bottom:20px;"></i>
            <h2 style="margin-bottom:10px;">Order Placed Successfully!</h2>
            <p style="color:#555; margin-bottom:20px;">Thank you for shopping with SakthiMart. Your order is being processed.</p>
            <button onclick="window.location.href='orders.php'" style="background:var(--amazon-orange); border:none; padding:10px 20px; border-radius:20px; font-weight:bold; cursor:pointer;">View Orders</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        // Toggle active styling on payment radio
        $('input[name="payment"]').on('change', function() {
            $('.payment-option').removeClass('active');
            $(this).parent('.payment-option').addClass('active');
            
            if($(this).parent().find('span').text().includes('Credit')) {
                $('.cc-form').slideDown();
            } else {
                $('.cc-form').slideUp();
            }
        });

        // Dummy Place Order function
        function placeOrder() {
            var $btn = $('.place-order-btn');
            $btn.html('<i class="fa-solid fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
            
            setTimeout(function() {
                // Clear cart in DB (simulated)
                $.post('php/cart_process.php', { action: 'clear_cart' }, function() {
                    $('.checkout-page').css('opacity', '0.5');
                    $('#success-modal').css('display', 'flex').hide().fadeIn();
                });
            }, 1500);
        }
    </script>
</body>
</html>
