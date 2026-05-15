<?php
// ============================================================
// SakthiMart — orders.php (Dummy Returns & Orders Page)
// ============================================================
$pageTitle = 'Your Orders';
require_once 'php/header.php';

// Ensure user is logged in
if (!isset($isLoggedIn) || !$isLoggedIn) {
    header('Location: login.php');
    exit;
}
?>
    <style>
        .orders-page {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .orders-header h1 {
            font-size: 28px;
            font-weight: 700;
        }

        .search-orders {
            display: flex;
            gap: 10px;
        }

        .search-orders input {
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 250px;
            outline: none;
        }

        .search-orders button {
            background-color: var(--amazon-dark);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            font-weight: 600;
        }

        .tabs {
            display: flex;
            gap: 30px;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .tab {
            padding: 10px 0;
            font-weight: 600;
            color: #007185;
            cursor: pointer;
            position: relative;
        }

        .tab.active {
            color: #c45500;
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #c45500;
        }

        .order-card {
            border: 1px solid #ddd;
            border-radius: var(--radius);
            margin-bottom: 24px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .order-header {
            background-color: #f0f2f2;
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            color: #555;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
        }

        .order-meta-group {
            display: flex;
            gap: 40px;
        }

        .order-meta {
            display: flex;
            flex-direction: column;
        }

        .order-meta span:first-child {
            text-transform: uppercase;
            font-size: 12px;
            font-weight: 600;
        }

        .order-meta span:last-child {
            color: var(--text-dark);
            font-weight: 500;
        }

        .order-actions-top a {
            color: #007185;
            text-decoration: none;
        }
        .order-actions-top a:hover {
            text-decoration: underline;
            color: #c45500;
        }

        .order-body {
            background: white;
            padding: 20px;
        }

        .delivery-status {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--success);
        }

        .order-item-wrap {
            display: flex;
            gap: 20px;
        }

        .order-item-wrap img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 4px;
            border: 1px solid #eee;
        }

        .order-item-details {
            flex: 1;
        }

        .order-item-details a {
            font-weight: 600;
            color: #007185;
            font-size: 15px;
            margin-bottom: 5px;
            display: block;
        }
        .order-item-details a:hover { text-decoration: underline; color: #c45500; }
        
        .order-item-details .return-window {
            font-size: 13px;
            color: #555;
            margin-top: 4px;
        }

        .order-buttons {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 200px;
        }

        .btn-action {
            background-color: white;
            border: 1px solid #d5d9d9;
            border-radius: 8px;
            padding: 8px 10px;
            text-align: center;
            font-size: 13px;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(213,217,217,.5);
        }

        .btn-action:hover {
            background-color: #f7fafa;
        }

        /* Order 2 specific (arriving) */
        .status-arriving { color: #c45500; }

    </style>

    <main>
        <div class="orders-page">
            <div class="orders-header">
                <h1>Your Orders</h1>
                <div class="search-orders">
                    <input type="text" placeholder="Search all orders">
                    <button>Search Orders</button>
                </div>
            </div>

            <div class="tabs">
                <div class="tab active">Orders</div>
                <div class="tab">Buy Again</div>
                <div class="tab">Not Yet Shipped</div>
                <div class="tab">Cancelled Orders</div>
            </div>

            <p style="margin-bottom:20px; color:#555; font-size:14px;"><span style="font-weight:700;color:black;">2 orders</span> placed in past 3 months</p>

            <!-- Dummy Order 1 -->
            <div class="order-card">
                <div class="order-header">
                    <div class="order-meta-group">
                        <div class="order-meta">
                            <span>Order Placed</span>
                            <span>20 April 2026</span>
                        </div>
                        <div class="order-meta">
                            <span>Total</span>
                            <span>₹14,999</span>
                        </div>
                        <div class="order-meta">
                            <span>Ship To</span>
                            <span style="color:#007185;cursor:pointer;"><?= htmlspecialchars($userName) ?> <i class="fa-solid fa-angle-down"></i></span>
                        </div>
                    </div>
                    <div class="order-actions-top">
                        <div style="font-size:12px;">ORDER # 408-1123445-9012345</div>
                        <a href="#">View order details</a> | <a href="#">Invoice</a>
                    </div>
                </div>
                <div class="order-body">
                    <div class="delivery-status status-arriving">Arriving Tomorrow by 9 PM</div>
                    <p style="color:#555;font-size:14px;margin-bottom:15px;">Tracking ID: SAKTHI987654321</p>
                    
                    <div style="display:flex; justify-content:space-between;">
                        <div class="order-item-wrap">
                            <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12?auto=format&fit=crop&w=150&q=80" alt="Product">
                            <div class="order-item-details">
                                <a href="#">Premium Smart Watch - Series 9, Midnight Black</a>
                                <p style="font-size:13px; color:#555;">Sold by: Sakthi Electronics Official</p>
                                <p style="font-size:13px; font-weight:700; margin-top:5px;">₹14,999</p>
                            </div>
                        </div>
                        <div class="order-buttons">
                            <button class="btn-action" style="background-color: #ffd814; border-color: #fcd200;">Track package</button>
                            <button class="btn-action">Cancel order</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dummy Order 2 -->
            <div class="order-card">
                <div class="order-header">
                    <div class="order-meta-group">
                        <div class="order-meta">
                            <span>Order Placed</span>
                            <span>15 March 2026</span>
                        </div>
                        <div class="order-meta">
                            <span>Total</span>
                            <span>₹2,450</span>
                        </div>
                        <div class="order-meta">
                            <span>Ship To</span>
                            <span style="color:#007185;cursor:pointer;"><?= htmlspecialchars($userName) ?> <i class="fa-solid fa-angle-down"></i></span>
                        </div>
                    </div>
                    <div class="order-actions-top">
                        <div style="font-size:12px;">ORDER # 404-5582991-2309812</div>
                        <a href="#">View order details</a> | <a href="#">Invoice</a>
                    </div>
                </div>
                <div class="order-body">
                    <div class="delivery-status">Delivered 18 Mar</div>
                    <p style="color:#555;font-size:14px;margin-bottom:15px;">Package was handed to resident.</p>
                    
                    <div style="display:flex; justify-content:space-between;">
                        <div class="order-item-wrap">
                            <img src="https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=150&q=80" alt="Product">
                            <div class="order-item-details">
                                <a href="#">Noise Cancelling Wireless Earbuds TWS</a>
                                <div class="return-window">Return window closed on 02 Apr 2026</div>
                                <div style="margin-top:10px;">
                                    <button class="btn-action" style="background:#fff;">Buy it again</button>
                                    <button class="btn-action" style="background:#fff;">View your item</button>
                                </div>
                            </div>
                        </div>
                        <div class="order-buttons">
                            <button class="btn-action">Write a product review</button>
                            <button class="btn-action">Archive order</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <?php require_once 'php/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</body>
</html>
