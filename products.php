<?php
// ============================================================
// SakthiMart — products.php (All Products Page)
// ============================================================
$pageTitle     = 'Products';
$metaDesc      = 'Browse all products on SakthiMart - Electronics, Fashion, and Lifestyle at the best prices.';
$active_category = isset($_GET['category']) ? trim($_GET['category']) : 'All';
require_once 'php/header.php';
?>

    <style>
        .category-bar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            padding: 15px 20px;
            max-width: 1400px;
            margin: 0 auto;
        }
        .category-btn {
            padding: 7px 18px;
            border: 1px solid #ccc;
            border-radius: 20px;
            background: white;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .category-btn:hover,
        .category-btn.active {
            background-color: var(--amazon-orange);
            border-color: var(--amazon-orange);
            color: var(--text-dark);
            font-weight: 700;
        }
    </style>

    <main>
        <section class="page-header"
            style="background-color: var(--amazon-light); color: white; padding: 40px 20px; text-align: center;">
            <h1>Our Products</h1>
            <p>Discover our wide range of premium electronics, fashion, and lifestyle products.</p>
        </section>

        <div class="category-bar">
            <?php foreach (['All', 'Electronics', 'Fashion'] as $cat): ?>
            <button class="category-btn <?= ($cat === $active_category) ? 'active' : '' ?>"
                    data-category="<?= ($cat === 'All') ? '' : $cat ?>">
                <?= htmlspecialchars($cat) ?>
            </button>
            <?php endforeach; ?>
        </div>

        <section class="product-section">
            <h2 class="section-title">All Products</h2>
            <div class="product-grid" id="all-products-grid" style="margin-top: 30px;"
                 data-category="<?= htmlspecialchars($active_category === 'All' ? '' : $active_category) ?>">
                <div style="padding:30px; text-align:center; color:#555; grid-column:1/-1;">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size:30px;color:#febd69;"></i>
                    <p style="margin-top:10px;">Loading products...</p>
                </div>
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

</body>
</html>
