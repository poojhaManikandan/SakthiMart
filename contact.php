<?php
// ============================================================
// SakthiMart — contact.php
// ============================================================
$pageTitle = 'Contact Us';
$metaDesc  = 'Contact SakthiMart - Get in touch with our support team or place an order enquiry.';
require_once 'php/header.php';
?>

    <main>
        <section class="page-header"
            style="background-color: var(--amazon-light); color: white; padding: 40px 20px; text-align: center;">
            <h1>Contact Us / Place an Order</h1>
            <p>We're here to help. Reach out to us with any questions or order requests.</p>
        </section>

        <section class="contact-section">
            <div class="contact-container">
                <div class="contact-info">
                    <h2>Get in Touch</h2>
                    <p><i class="fa-solid fa-location-dot"></i> 123 Tech Park, Chennai, India</p>
                    <p><i class="fa-solid fa-envelope"></i> support@sakthimart.com</p>
                    <p><i class="fa-solid fa-phone"></i> +91 98765 43210</p>
                    <div class="working-hours">
                        <h3>Working Hours</h3>
                        <p>Mon - Fri: 9:00 AM - 8:00 PM</p>
                        <p>Sat - Sun: 10:00 AM - 5:00 PM</p>
                    </div>
                </div>

                <div class="contact-form-container">
                    <h2>Send a Message</h2>
                    <form id="contact-form" class="contact-form" method="POST">
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" id="full_name" name="full_name"
                                   placeholder="John Doe"
                                   value="<?= htmlspecialchars($_SESSION['user_name'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email"
                                   placeholder="john@example.com"
                                   value="<?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="order_id">Order ID (Optional)</label>
                            <input type="text" id="order_id" name="order_id" placeholder="SM-12345678">
                        </div>
                        <div class="form-group">
                            <label for="message">Your Message</label>
                            <textarea id="message" name="message" rows="5"
                                placeholder="How can we help you today?" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn" id="contact-submit-btn">Send Message</button>
                    </form>
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
