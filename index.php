<?php
// ============================================================
// SakthiMart — index.php (Home Page)
// ============================================================
$pageTitle = 'Your Premium Shopping Hub';
$metaDesc  = 'SakthiMart - Your premium shopping hub for electronics, fashion, and lifestyle products at unbeatable prices.';
require_once 'php/header.php';
?>

    <main>
        <section class="hero"
            style="background: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(243,243,243,1)), url('https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?q=80&w=2070&auto=format&fit=crop');">
            <div class="hero-content">
                <h1>Welcome to SakthiMart</h1>
                <p>Unbeatable deals on everything you love</p>
                <br>
                <a href="#" class="hero-btn">Explore Now</a>
            </div>
        </section>

        <div class="container">
            <div class="featured-grid">
                <div class="feature-card">
                    <h2>Latest Fashion</h2>
                    <img src="https://images.unsplash.com/photo-1483985988355-763728e1935b?q=80&w=2070&auto=format&fit=crop"
                        alt="Fashion Trends">
                    <a href="products.php?category=Fashion">See all offers</a>
                </div>
                <div class="feature-card">
                    <h2>Smart Gadgets</h2>
                    <img src="https://images.unsplash.com/photo-1468495244123-6c6c332eeece?q=80&w=2042&auto=format&fit=crop"
                        alt="Electronics">
                    <a href="products.php?category=Electronics">Shop Now</a>
                </div>
                <div class="feature-card">
                    <h2>Home Essentials</h2>
                    <img src="https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=2070&auto=format&fit=crop"
                        alt="Home Decor">
                    <a href="products.php">Explore Styles</a>
                </div>
                <div class="feature-card">
                    <h2>Gamer's Paradise</h2>
                    <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?q=80&w=2070&auto=format&fit=crop"
                        alt="Gaming Setup">
                    <a href="products.php?category=Electronics">New Releases</a>
                </div>
            </div>
        </div>

        <section class="product-section">
            <h2 class="section-title">Trending Now</h2>
            <!-- Products loaded dynamically via jQuery AJAX -->
            <div class="product-grid" id="trending-grid">
                <div style="padding:30px; text-align:center; color:#555;">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size:30px;color:#febd69;"></i>
                    <p style="margin-top:10px;">Loading products...</p>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-top" onclick="window.scrollTo({top: 0, behavior: 'smooth'})">
            Back to top
        </div>
        <div class="footer-content">
            <div class="footer-column">
                <h3>Get to Know Us</h3>
                <ul>
                    <li>About Us</li>
                    <li>Careers</li>
                    <li>Press Releases</li>
                    <li>SakthiMart Science</li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Connect with Us</h3>
                <ul>
                    <li>Facebook</li>
                    <li>Twitter</li>
                    <li>Instagram</li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Make Money with Us</h3>
                <ul>
                    <li>Sell on SakthiMart</li>
                    <li>Protect and Build Your Brand</li>
                    <li>Become an Affiliate</li>
                    <li>Advertise Your Products</li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Let Us Help You</h3>
                <ul>
                    <li>Your Account</li>
                    <li>Returns Centre</li>
                    <li>100% Purchase Protection</li>
                    <li>SakthiMart App Download</li>
                    <li>Help</li>
                </ul>
            </div>
        </div>
    </footer>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- SakthiMart JS -->
    <script src="js/main.js"></script>
    <script>
        $(function () {
            // Show flash toast from registration/login
            if (window.__flashSuccess) {
                // wait for main.js showToast to be ready
                setTimeout(function() { showToast(window.__flashSuccess, 'success'); }, 200);
            }

            // Load trending products into the home grid
            $.getJSON('php/get_products.php', function (res) {
                if (res.success) {
                    var $grid = $('#trending-grid');
                    $grid.empty();
                    res.products.slice(0, 5).forEach(function (p) {
                        var stars = '';
                        var r = parseFloat(p.rating);
                        for (var i = 1; i <= 5; i++) stars += i <= r ? '★' : '☆';
                        var count = Number(p.review_count).toLocaleString('en-IN');
                        var price = '₹' + Number(p.price).toLocaleString('en-IN');
                        $grid.append(`
                            <div class="product-card"
                                 data-id="${p.id}"
                                 data-name="${p.name.replace(/"/g, '&quot;')}"
                                 data-price="${p.price}"
                                 data-image="${p.image_url}">
                                <img src="${p.image_url}" alt="${p.name}" loading="lazy">
                                <h3 class="product-title">${p.name}</h3>
                                <div class="product-rating">${stars} (${count})</div>
                                <div class="product-price">${price}</div>
                                <button class="add-to-cart">Add to Cart</button>
                            </div>`);
                    });
                }
            }).fail(function () {
                $('#trending-grid').html('<p style="padding:20px;color:#B12704;">Could not load products. Make sure the database is set up.</p>');
            });
        });

        // Expose showToast globally for flash messages
        function showToast(msg, type) {
            // Will be overridden by main.js after load — this is a fallback
            console.log(type + ':', msg);
        }
    </script>

</body>
</html>