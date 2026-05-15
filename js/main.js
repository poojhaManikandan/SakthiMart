/**
 * SakthiMart — main.js
 * jQuery-powered cart, product loading, search, and contact form.
 * Requires jQuery 3.x (loaded via CDN in each PHP page)
 */

$(function () {

    /* =========================================================
       CONFIGURATION
    ========================================================= */
    const BASE = '';          // empty → same-origin relative paths
    const CART_API    = BASE + 'php/get_cart.php';
    const ADD_API     = BASE + 'php/add_to_cart.php';
    const REMOVE_API  = BASE + 'php/remove_from_cart.php';
    const PROD_API    = BASE + 'php/get_products.php';
    const CONTACT_API = BASE + 'php/contact_submit.php';

    /* =========================================================
       TOAST NOTIFICATION
    ========================================================= */
    // Inject toast container once
    if ($('#sm-toast').length === 0) {
        $('body').append(`
            <div id="sm-toast" style="
                position:fixed; bottom:30px; right:30px; z-index:9999;
                display:flex; flex-direction:column; gap:10px; pointer-events:none;">
            </div>
        `);
    }

    function showToast(msg, type = 'success') {
        const colors = {
            success : { bg:'#232f3e', border:'#febd69', icon:'✓' },
            error   : { bg:'#B12704', border:'#ff6b47', icon:'✕' },
            info    : { bg:'#007185', border:'#00b3cc', icon:'ℹ' },
        };
        const c   = colors[type] || colors.success;
        const id  = 'toast-' + Date.now();
        const $t  = $(`
            <div id="${id}" style="
                background:${c.bg}; color:#fff; padding:14px 20px;
                border-left:4px solid ${c.border}; border-radius:6px;
                box-shadow:0 4px 16px rgba(0,0,0,.35); min-width:260px;
                font-size:14px; font-weight:500; font-family:'Inter',sans-serif;
                display:flex; align-items:center; gap:10px;
                opacity:0; transform:translateX(40px); transition: all .3s ease;
                pointer-events:all;">
                <span style="font-size:18px;color:${c.border}">${c.icon}</span>
                <span>${msg}</span>
            </div>
        `);
        $('#sm-toast').append($t);
        // Animate in
        setTimeout(() => $t.css({ opacity: 1, transform: 'translateX(0)' }), 20);
        // Animate out after 3s
        setTimeout(() => {
            $t.css({ opacity: 0, transform: 'translateX(40px)' });
            setTimeout(() => $t.remove(), 350);
        }, 3000);
    }

    /* =========================================================
       CART COUNT — update the badge on all pages
    ========================================================= */
    function updateCartBadge(count) {
        $('.cart-count').text(count > 0 ? count : 0);
    }

    function fetchCartCount() {
        $.getJSON(CART_API, function (res) {
            if (res.success) updateCartBadge(res.cart_count);
        });
    }

    // Run on every page load
    fetchCartCount();

    /* =========================================================
       CART ICON — click to go to cart page
    ========================================================= */
    $(document).on('click', '.cart-link', function () {
        window.location.href = 'cart.php';
    });

    /* =========================================================
       LOAD + RENDER PRODUCTS (index.php & products.php)
    ========================================================= */
    function buildStarHTML(rating) {
        const full  = Math.floor(rating);
        const half  = (rating - full) >= 0.5;
        const empty = 5 - full - (half ? 1 : 0);
        return '★'.repeat(full) + (half ? '½' : '') + '☆'.repeat(empty);
    }

    function renderProducts(products, $container) {
        $container.empty();
        if (!products || products.length === 0) {
            $container.html('<p style="padding:20px;color:#555;">No products found.</p>');
            return;
        }
        products.forEach(function (p) {
            const stars = buildStarHTML(parseFloat(p.rating));
            const count = Number(p.review_count).toLocaleString('en-IN');
            const price = '₹' + Number(p.price).toLocaleString('en-IN');
            const card  = `
                <div class="product-card"
                     data-id="${p.id}"
                     data-name="${p.name.replace(/"/g,'&quot;')}"
                     data-price="${p.price}"
                     data-image="${p.image_url}">
                    <img src="${p.image_url}" alt="${p.name}" loading="lazy">
                    <h3 class="product-title">${p.name}</h3>
                    <div class="product-rating">${stars} (${count})</div>
                    <div class="product-price">${price}</div>
                    <button class="add-to-cart">Add to Cart</button>
                </div>`;
            $container.append(card);
        });
    }

    // Products main section
    var $grid = $('.product-grid');
    if ($grid.length) {
        // Read initial category from data attribute if set
        var initialCat = $grid.data('category') || '';
        loadProducts('', initialCat);
    }

    function loadProducts(search, category) {
        var params = {};
        if (search)   params.search   = search;
        if (category) params.category = category;

        $.getJSON(PROD_API, params, function (res) {
            if (res.success) renderProducts(res.products, $('.product-grid'));
        }).fail(function () {
            showToast('Could not load products. Check DB connection.', 'error');
        });
    }

    /* =========================================================
       LIVE SEARCH (nav search bar)
    ========================================================= */
    var searchTimer;
    $(document).on('input', '.nav-search input', function () {
        clearTimeout(searchTimer);
        var q = $(this).val().trim();
        searchTimer = setTimeout(function () {
            if ($grid.length) loadProducts(q, '');
        }, 350);
    });

    $(document).on('click', '.nav-search button', function () {
        var q = $('.nav-search input').val().trim();
        if ($grid.length) loadProducts(q, '');
    });

    // Also trigger search on Enter key
    $(document).on('keydown', '.nav-search input', function (e) {
        if (e.key === 'Enter') {
            var q = $(this).val().trim();
            if ($grid.length) loadProducts(q, '');
        }
    });

    /* =========================================================
       CATEGORY FILTER (products.php)
    ========================================================= */
    $(document).on('click', '.category-btn', function () {
        $('.category-btn').removeClass('active');
        $(this).addClass('active');
        var cat = $(this).data('category') || '';
        var q   = $('.nav-search input').val().trim();
        loadProducts(q, cat);
    });

    /* =========================================================
       ADD TO CART
    ========================================================= */
    $(document).on('click', '.add-to-cart', function () {
        var $card = $(this).closest('.product-card');
        var id    = $card.data('id');
        var name  = $card.data('name');
        var price = $card.data('price');
        var img   = $card.data('image');

        if (!id) {
            showToast('Product data missing. Please refresh.', 'error');
            return;
        }

        var $btn = $(this);
        $btn.text('Adding...').prop('disabled', true);

        $.ajax({
            url    : ADD_API,
            method : 'POST',
            data   : { product_id: id, name: name, price: price, image_url: img },
            success: function (res) {
                if (res.success) {
                    updateCartBadge(res.cart_count);
                    showToast(res.message || 'Added to cart!', 'success');
                } else {
                    if (res.error === 'auth') {
                        showToast(res.message, 'info');
                        setTimeout(function() { window.location.href = 'login.php'; }, 1500);
                    } else {
                        showToast(res.error || 'Failed to add item.', 'error');
                    }
                }
            },
            error: function () {
                showToast('Server error. Try again.', 'error');
            },
            complete: function () {
                $btn.text('Add to Cart').prop('disabled', false);
            }
        });
    });

    /* =========================================================
       CART PAGE — render cart items
    ========================================================= */
    var $cartContainer = $('#cart-items-container');
    if ($cartContainer.length) {
        loadCartPage();
    }

    function loadCartPage() {
        $.getJSON(CART_API, function (res) {
            $cartContainer.empty();
            if (!res.success || res.items.length === 0) {
                $cartContainer.html(`
                    <div class="empty-cart">
                        <i class="fa-solid fa-cart-shopping" style="font-size:60px;color:#ccc;margin-bottom:20px;"></i>
                        <h2>Your cart is empty</h2>
                        <p>Looks like you haven't added anything yet.</p>
                        <a href="products.php" class="hero-btn" style="display:inline-block;margin-top:20px;">
                            Shop Now
                        </a>
                    </div>`);
                $('#cart-grand-total').text('₹0');
                return;
            }
            res.items.forEach(function (item) {
                $cartContainer.append(`
                    <div class="cart-item" data-id="${item.product_id}">
                        <img src="${item.image_url}" alt="${item.name}">
                        <div class="cart-item-info">
                            <p class="cart-item-name">${item.name}</p>
                            <p class="cart-item-price">${item.price_formatted}</p>
                        </div>
                        <div class="cart-item-controls">
                            <button class="qty-btn remove-one-btn" data-id="${item.product_id}">−</button>
                            <span class="cart-item-qty">${item.qty}</span>
                            <button class="qty-btn add-one-btn"
                                data-id="${item.product_id}"
                                data-name="${item.name.replace(/"/g,'&quot;')}"
                                data-price="${item.price}"
                                data-image="${item.image_url}">+</button>
                        </div>
                        <div class="cart-item-subtotal">${item.subtotal_formatted}</div>
                        <button class="remove-item-btn" data-id="${item.product_id}" title="Remove">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>`);
            });
            $('#cart-grand-total').text(res.grand_total_formatted);
            updateCartBadge(res.cart_count);
        });
    }

    // Increase qty from cart
    $(document).on('click', '.add-one-btn', function () {
        var id    = $(this).data('id');
        var name  = $(this).data('name');
        var price = $(this).data('price');
        var img   = $(this).data('image');
        $.post(ADD_API, { product_id: id, name: name, price: price, image_url: img }, function (res) {
            if (res.success) { updateCartBadge(res.cart_count); loadCartPage(); }
        });
    });

    // Decrease qty from cart
    $(document).on('click', '.remove-one-btn', function () {
        var id = $(this).data('id');
        $.post(REMOVE_API, { product_id: id }, function (res) {
            if (res.success) { updateCartBadge(res.cart_count); loadCartPage(); }
        });
    });

    // Remove entire item from cart
    $(document).on('click', '.remove-item-btn', function () {
        var id = $(this).data('id');
        // Remove all qty by calling remove until gone (simple approach: clear via POST loop isn't ideal;
        // instead pass force flag)
        $.post(REMOVE_API, { product_id: id, force: 1 }, function () {
            fetchCartCount();
            loadCartPage();
        });
    });

    /* =========================================================
       CONTACT FORM — AJAX submit
    ========================================================= */
    $(document).on('submit', '#contact-form', function (e) {
        e.preventDefault();
        var $btn = $(this).find('.submit-btn');
        $btn.text('Sending...').prop('disabled', true);

        $.ajax({
            url    : CONTACT_API,
            method : 'POST',
            data   : $(this).serialize(),
            success: function (res) {
                if (res.success) {
                    showToast(res.message, 'success');
                    $('#contact-form')[0].reset();
                } else {
                    var errs = res.errors ? res.errors.join(' | ') : 'Submission failed.';
                    showToast(errs, 'error');
                }
            },
            error: function () {
                showToast('Server error. Please try again.', 'error');
            },
            complete: function () {
                $btn.text('Send Message').prop('disabled', false);
            }
        });
    });

    /* =========================================================
       HERO BUTTON — scroll to trending section
    ========================================================= */
    $(document).on('click', '.hero-btn', function (e) {
        var href = $(this).attr('href');
        if (!href || href === '#') {
            e.preventDefault();
            var $target = $('.product-section');
            if ($target.length) {
                $('html,body').animate({ scrollTop: $target.offset().top - 80 }, 500);
            }
        }
    });

});
