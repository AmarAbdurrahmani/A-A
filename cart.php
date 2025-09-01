<?php
session_start();
include "db.php";

// Simulate login user
$_SESSION['user_id'] = 1;
$user_id = $_SESSION['user_id'];

// Show cart items
$stmt = $pdo->prepare("SELECT c.*, p.name, p.price, p.image 
                       FROM cart c
                       JOIN products p ON c.product_id = p.id
                       WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Cart - A&A</title>
<link rel="icon" type="image/png" href="img/logo.png">
<link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Petrona&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<style>
        body {
            margin: 0;
            font-family: 'Petrona', sans-serif;
            background-color: #FFFFFF;
            color: #fff;
        }
        html {
            scroll-behavior: smooth;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
        }
        .logo {
            font-size: 2em;
            font-weight: 700;
            color: #fff;
            letter-spacing: 2px;
        }
        /* DESKTOP NAV-LINKS */
        .nav-links {
            display: flex;
            align-items: center;
        }
        .nav-links ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            gap: 20px;
            position: absolute;
            left: 31%;
        }
        .nav-links li {
            margin: 0 15px;
        }
        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-weight: 400;
            font-size: 0.9em;
            letter-spacing: 1px;
            position: relative;
            padding-bottom: 5px;
            transition: color 0.3s ease;
        }
        .nav-links a:hover::after {
            width: 100%;
        }
        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #fff;
            transition: width 0.3s ease;
        }
        .nav-icons a {
            color: #fff;
            text-decoration: none;
            font-size: 1.1em;
            margin-left: 25px;
            transition: color 0.3s ease;
        }
        .hero {
            position: relative;
            height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: linear-gradient(to right, rgba(26, 26, 26, 0.7), rgba(0, 0, 0, 0.7)), 
                        url("img/background.jpg") no-repeat center center;
            background-size: cover;
            background-position: center 5%;
        }
        .background-text {
            font-family: 'Petrona', sans-serif;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            pointer-events: none;
            opacity: 0.1;
            overflow: hidden;
        }
        .bg-text {
            font-size: 20vw;
            font-weight: 700;
            color: #fff;
            line-height: 0.8;
            letter-spacing: 10px;
            position: absolute;
            transform: rotate(-10deg) translate(-50%, -50%);
            top: -50%;
            left: -20%;
        }

        .bg-text:nth-child(2) {
            top: 50%;
            left: 0;
            transform: rotate(-10deg) translate(-50%, -50%);
        }
        .bg-text:nth-child(3) {
            top: 150%;
            left: 50%;
            transform: rotate(-10deg) translate(-50%, -50%);
        }
        .bg-text:nth-child(4) {
            top: 50%;
            left: 100%;
            transform: rotate(-10deg) translate(-50%, -50%);
        }
        .bg-text:nth-child(5) {
            top: 150%;
            left: 150%;
            transform: rotate(-10deg) translate(-50%, -50%);
        }

        .cart-link {
            position: relative;
        }
        #cart-count {
            background: white;
            color: black;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 50%;
            position: absolute;
            top: -8px;
            right: -10px;
        }
        
        .newsletter {
            background: linear-gradient(rgba(17, 17, 17, 0.8), rgba(17, 17, 17, 0.8)),
                        url('img/image.png') center/cover no-repeat;
            color: #fff;
            padding: 150px 10%;
            position: relative;
            z-index: 20000;
        }
        .newsletter-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .newsletter-form input {
            font-family: 'Young Serif', serif;
            padding: 12px;
            border: none;
            border-radius: 4px;
            width: 250px;
        }
        .newsletter-form button {
            font-family: 'Young Serif', serif;
            padding: 12px 20px;
            background: #000;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }
        .footer {
            position: relative;
            padding: 50px 10%;
            font-family: 'Abhaya Libre', serif;
            color: #fff;
            background: linear-gradient(rgba(17,17,17,0.8), rgba(17,17,17,0.8)),
                        url('img/background.jpg') center/cover no-repeat;
            background-size: cover;
            overflow: hidden;
            background-position: center 3%;
        }

        .footer .background-text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            opacity: 0.05;
        }

        .footer .bg-text {
            font-size: 20vw;
            font-weight: 700;
            color: #fff;
            line-height: 0.8;
            letter-spacing: 10px;
            position: absolute;
            transform: rotate(-10deg) translate(-50%, -50%);
        }

        .footer .bg-text:nth-child(1) { top: -50%; left: -20%; }
        .footer .bg-text:nth-child(2) { top: 50%; left: 0; }
        .footer .bg-text:nth-child(3) { top: 150%; left: 50%; }
        .footer .bg-text:nth-child(4) { top: 50%; left: 100%; }
        .footer .bg-text:nth-child(5) { top: 150%; left: 150%; }

        .footer-top {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 40px;
        }
        .footer-logo h3 {
            font-size: 2rem;
        }
        .social-icons a {
            color: #fff;
            margin-right: 10px;
            font-size: 1.1rem;
        }
        .footer-links {
            display: flex;
            gap: 90px;
        }
        .footer-links a {
            display: block;
            color: #ccc;
            margin-bottom: 6px;
            text-decoration: none;
        }
        .footer-bottom {
            margin-top: 30px;
            border-top: 1px solid #444;
            padding-top: 15px;
            display: flex;
            justify-content: space-between;
        }
        
        /* Hide hamburger menu on desktop by default */
        .hamburger,
        .close-menu {
            display: none;
            cursor: pointer;
        }
        /* Popup directly under button */
        .popup-inline {
            display: none;
            margin-top: 8px;
            background: black;
            color: white;
            padding: 12px 20px;
            border-radius: 4px;
            font-size: 0.9rem;
            text-align: center;
            width: fit-content;
            animation: fadeIn 0.3s ease;
        }

        /* Fade animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ===== Shop Section ===== */
        .shop-section {
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .hoodie-top {
            width: 100%;
            height: 553px;
            object-fit: cover;
            object-position: center -200px;
            display: block;
        }

        .shop-container {
            position: relative;
            margin-top: -1100px;
            background: white;
            width: 95%;
            max-width: 1000px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-radius: 10px;
            z-index: 1;
        }


        .shop-title {
            text-align: center;
            margin-bottom: 20px;
            color: #000;
        }

        .shop-filters {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        select {
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        /* --- PRODUCTS GRID --- */
        .products-grid {
            font-family: 'Abhaya Libre', serif;
            position: relative;
            z-index: 10;
            margin-top: -500px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); /* Default desktop layout */
            gap: 30px;
            padding: 20px;
            color: #000;
        }

        .product {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            text-align: center;
        }
        .product:hover {
            transform: translateY(-5px);
        }
        .product img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 10px;
        }
        .product h3 {
            margin-bottom: 5px;
            color: #000;
        }
        .product p {
            font-weight: bold;
            color: #333;
        }

        .cart {
            font-family: 'Abhaya Libre', serif;
            position: absolute;
            top: 120px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 2.5rem;
            font-weight: bold;
            color: #fff;
            text-align: center;
            z-index: 11;
        }

        .cart-link {
            position: relative;
        }

        #cart-count {
            background: white;
            color: black;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 50%;
            position: absolute;
            top: -8px;
            right: -10px;
        }
        .product-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin: 10px 0;
        }
        .qty-label, .size-label {
            font-weight: bold;
            color: #000;
        }
        .checkout-container {
            text-align: center;
            margin: 20px 0;
        }

        .cart-summary {
            margin-top: 20px;
            text-align: left;
            padding-left: 20px; /* Aligns with product cards */
        }
        .cart-summary h3 {
            color: #000;
        }

        #checkout-btn {
            font-family: 'Petrona', sans-serif;
            margin-top: 10px;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #000;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #checkout-btn:hover {
            background-color: #444;
        }
        #total {
            background-color: #fff;
            color: #000;
            padding: 10px 15px;
            border-radius: 5px;
            display: block;
            font-weight: bold;
            margin-top: 20px;
            width: fit-content;
        }

        /* === Checkout Slide-in Panel === */
        .checkout-panel {
            position: fixed;
            top: 0;
            right: -100%;
            width: 500px;
            height: 100%;
            background: #fff;
            color: #000;
            box-shadow: -2px 0 10px rgba(0,0,0,0.3);
            transition: right 0.4s ease;
            z-index: 2000;
            padding: 20px;
        }

        /* Blur background when panel is open */
        body.checkout-open::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 30%; bottom: 0;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(2px);
            z-index: 1500;
        }

        /* Checkout Content */
        .checkout-content {
            position: relative;
            height: 100%;
            overflow-y: auto;
        }

        .checkout-content h2 {
            margin-bottom: 20px;
        }

        .checkout-content input {
            display: block;
            width: 95%;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .checkout-content button {
            width: 100%;
            padding: 12px;
            background: black;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
        }

        .checkout-content button:hover {
            background: #444;
        }

        /* Close (X) Button */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            background: none;
            border: none;
            font-size: 1.2rem;
            color: #000;
            cursor: pointer;
            line-height: 1;
            padding: 0;
        }

        .close-btn:hover {
            background-color: #444;
        }

        /* === Payment Confirmation Popup === */
        .payment-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            background: black;
            color: white;
            padding: 20px 40px;
            border-radius: 8px;
            font-size: 1.2rem;
            display: none;
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 3000;
        }

        .payment-popup.show {
            display: block;
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }
        .p9 {
            color: white;
        }
        .remove-btn {
            background-color: black;
            color: white;
            border-radius: 3px;
        }

        /* ============================ */
        /* ===== RESPONSIVE STYLES ==== */
        /* ============================ */

        /* Tablets & Mobile (up to 992px) */
        @media (max-width: 992px) {
            
            /* Show hamburger and close icons */
            .hamburger, .close-menu {
                display: block;
                cursor: pointer;
                z-index: 1001;
            }

            /* Hide the desktop nav links by default */
            .nav-links {
                position: fixed;
                top: 0;
                right: -100%;
                width: 70%;
                max-width: 280px;
                height: 100vh;
                background: #fff;
                box-shadow: -5px 0 15px rgba(0,0,0,0.1);
                transition: right 0.4s ease-in-out;
                z-index: 1000;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                padding: 20px;
            }
            .nav-links.active {
                right: 0;
            }

            .close-menu {
                align-self: flex-end;
                color: #000;
                font-size: 28px;
            }
            
            /* Style the list of links */
            .nav-links ul {
                flex-direction: column;
                width: 100%;
                margin-top: 20px;
                position: static; /* Important: remove absolute positioning */
                left: unset;
                transform: unset;
            }
            .nav-links li {
                margin: 15px 0;
            }
            .nav-links a {
                color: #000;
                font-size: 1.1em;
            }
            .nav-links a::after {
                background-color: #000;
            }
            
            /* Style the icons container inside the menu */
            .nav-links .nav-icons {
                margin-top: 20px; /* Pushes icons to the bottom */
                padding-top: 20px;
                border-top: 1px solid #eee;
                width: 100%;
                display: flex;
                justify-content: flex-start;
                gap: 30px; /* Space out the icons */
            }
            
            .nav-links .nav-icons a {
                color: #000;
                font-size: 1.5em;
                margin-left: 0;
            }
            #cart-count {
                color: #fff;
                background: #000;
            }

            /* Make products display two per line on tablets/phones */
            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            .newsletter-content {
        flex-direction: column; /* Stack the text and form */
        text-align: center;      /* Center the heading and paragraph */
        gap: 25px;
    }
    
    .footer-top,
    .footer-bottom {
        flex-direction: column;
        text-align: center;
        align-items: center;
    }

    /* THIS IS THE NEW, CORRECTED RULE */
    .footer-links {
        flex-direction: column;
        text-align: center;
        gap: 30px; /* Use a larger gap for vertical stacking */
    }
    .hero {
    height: 40vh; /* Make the hero section much shorter on phones */
  }

  .products-grid {
    margin-top: -20vh; /* Adjust the margin to pull products up into the new space */
  }
        }

        /* Mobile Phones (up to 576px) */
        @media (max-width: 576px) {
            .navbar {
                padding: 15px 20px;
            }
            .logo {
                font-size: 1.5em;
            }

            /* Single column for products on small phones */
            .products-grid {
                grid-template-columns: 1fr;
            }
            
            .checkout-panel {
                width: 90%; /* Make the checkout panel wider on smaller screens */
            }

            .footer-top, .footer-bottom, .newsletter-content {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }
            .footer-links {
                flex-direction: column;
                gap: 30px;
            }
            .newsletter-form input, .newsletter-form button {
                width: 100%;
            }
        }
        
    </style>
</head>
<body>
<header class="navbar">
        <div class="logo">A&A</div>

        <div class="hamburger"><i class="fa-solid fa-bars"></i></div>
        
        <nav class="nav-links">
            <span class="close-menu"><i class="fa-solid fa-xmark"></i></span>
            <ul>
                <li><a href="index.html">HOME</a></li>
                <li><a href="shop.html">SHOP</a></li>
                <li><a href="shop.html?category=hoodies">HOODIES</a></li>
                <li><a href="shop.html?category=tshirts">T-SHIRTS</a></li>
                <li><a href="shop.html?category=accessories">ACCESSORIES</a></li>
                <li><a href="shop.html?category=jackets">JACKETS</a></li>
            </ul>
            
            <div class="nav-icons">
                <a href="Login.php"><i class="fa-regular fa-user"></i></a>
                <a href="favorites.php"><i class="fa-regular fa-heart"></i></a>
                <a href="cart.php" class="cart-link">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span id="cart-count">0</span>
                </a>
            </div>
        </nav>
    </header>

<main class="hero">
    <div class="background-text">
        <span class="bg-text">A&A</span>
        <span class="bg-text">A&A</span>
        <span class="bg-text">A&A</span>
        <span class="bg-text">A&A</span>
        <span class="bg-text">A&A</span>
    </div>
    <h1 class="cart">My Cart</h1>
</main>

<div class="products-grid">
<?php if($cartItems): ?>
    <?php $totalPrice = 0; ?>
    <?php foreach($cartItems as $item): 
        $subtotal = $item['price'] * $item['quantity'];
        $totalPrice += $subtotal;
    ?>
    <div class="product" data-id="<?= $item['product_id'] ?>">
        <img src="<?= $item['image'] ?>" alt="<?= $item['name'] ?>">
        <h3><?= $item['name'] ?></h3>
        <p><strong>Price:</strong> $<?= $item['price'] ?></p>

        <div class="product-controls">
    <label class="qty-label">Quantity:
        <select class="qty-select">
            <?php for($i=1;$i<=10;$i++): ?>
                <option value="<?= $i ?>" <?= $i==$item['quantity']?'selected':'' ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>
    </label>

    <label class="size-label">Size:
        <select class="size-select">
            <?php 
            $sizes = ['XS','S','M','L','XL','XXL'];
            foreach($sizes as $size): ?>
                <option value="<?= $size ?>" <?= $item['size']==$size?'selected':'' ?>><?= $size ?></option>
            <?php endforeach; ?>
        </select>
    </label>
</div>



        <p>Subtotal: $<span class="product-subtotal"><?= $subtotal ?></span></p>

        


        <!-- Remove Button -->
        <button class="remove-btn">Remove</button>
    </div>
    <?php endforeach; ?>
    <div class="cart-summary">
        <h3 id="total">Total: $<span id="cart-total"><?= $totalPrice ?></span></h3>
        <button id="checkout-btn">Proceed to Checkout</button>
    </div>
<?php else: ?>
    <p class="p9">Your cart is empty.</p>
<?php endif; ?>
</div>

<!-- Checkout Panel -->
<div id="checkout-panel" class="checkout-panel">
    <div class="checkout-content">
        <button id="close-checkout" class="close-btn">&times;</button>
        <h2>Checkout</h2>
        <form id="checkout-form">
            <label>Email</label>
            <input type="email" required>

            <label>First Name</label>
            <input type="text" required>

            <label>Last Name</label>
            <input type="text" required>

            <label>Address</label>
            <input type="text" required>

            <label>City</label>
            <input type="text" required>

            <label>Phone</label>
            <input type="tel" required>

            <button type="submit" id="pay-btn">PAY NOW</button>
        </form>
    </div>
</div>


<!-- Confirmation Popup -->
<div id="payment-popup" class="payment-popup">
    <p>Your payment is confirmed 🎉</p>
</div>



    <!-- Newsletter -->
    <section class="newsletter">
        <div class="newsletter-content">
            <div class="newsletter-text">
                <h2>Get 20% OFF on your first purchase</h2>
                <p>Sign up for our newsletter and never miss any offers</p>
            </div>
            <form id="newsletter-form" class="newsletter-form" action="newsletter.php" method="post">
            <input type="email" name="email" placeholder="Your email address" required>
            <button type="submit">SUBSCRIBE NOW</button>
        </form>
            <div id="subscribe-popup" class="popup-inline">You subscribed!</div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="background-text">
            <span class="bg-text">A&A</span>
            <span class="bg-text">A&A</span>
            <span class="bg-text">A&A</span>
            <span class="bg-text">A&A</span>
        </div>
        <div class="footer-top">
            <div class="footer-logo">
                <h3>A&A</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-pinterest-p"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <div>
                    <h4>QUICK LINKS</h4>
                    <a href="#">Home</a>
                    <a href="#">About us</a>
                    <a href="#">Offers</a>
                    <a href="#">Services</a>
                    <a href="#">Contact Us</a>
                </div>
                <div>
                    <h4>ABOUT</h4>
                    <a href="#">How It Work</a>
                    <a href="#">Our Packages</a>
                    <a href="#">Promotions</a>
                    <a href="#">Refer A Friend</a>
                </div>
                <div>
                    <h4>HELP CENTER</h4>
                    <a href="#">Payments</a>
                    <a href="#">Shipping</a>
                    <a href="#">Product Returns</a>
                    <a href="#">FAQs</a>
                    <a href="#">Check out</a>
                    <a href="#">Other Issues</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2025 A&A. All rights reserved.</p>
            <p>Designed & Developed by <strong>Amar Abdurrahmani</strong></p>
        </div>
    </footer>

<script>
    
const hamburger = document.querySelector(".hamburger");
        const navLinks = document.querySelector(".nav-links");
        const closeMenu = document.querySelector(".close-menu");
        
        hamburger.addEventListener("click", () => {
            navLinks.classList.add("active");
        });

        closeMenu.addEventListener("click", () => {
            navLinks.classList.remove("active");
        });


// ===== JS for cart actions =====
document.querySelectorAll('.products-grid .product').forEach(product => {
    const productId = product.dataset.id;
    const price = parseFloat(product.querySelector('p strong').nextSibling.textContent.replace('$','')) || 0;
    const qtySelect = product.querySelector('.qty-select');
    const sizeSelect = product.querySelector('.size-select');
    const subtotalEl = product.querySelector('.product-subtotal');
    const removeBtn = product.querySelector('.remove-btn');

    function sendUpdate(action, data) {
        fetch('actions.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ action, product_id: productId, ...data })
        }).then(res => res.json())
          .then(res => {
              if(res.status !== 'success') console.error(res.message);
          });
    }

    // Quantity change
    qtySelect.addEventListener('change', () => {
        const qty = parseInt(qtySelect.value);
        subtotalEl.textContent = (price * qty).toFixed(2);
        updateTotal();
        sendUpdate('update_quantity', { quantity: qty });
    });

    // Size change
    sizeSelect.addEventListener('change', () => {
        sendUpdate('update_size', { size: sizeSelect.value });
    });

    // Remove item
    removeBtn.addEventListener('click', () => {
        product.remove();
        updateTotal();
        sendUpdate('remove', {});
    });
});

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.product').forEach(product => {
        total += parseFloat(product.querySelector('.product-subtotal').textContent);
    });
    document.getElementById('cart-total').textContent = total.toFixed(2);
}
updateTotal();

function updateCartIconCount() {
    fetch("actions.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=get_cart_count"
    })
    .then(res => res.json())
    .then(data => {
        const cartCountEl = document.getElementById("cart-count");
        if (cartCountEl) cartCountEl.textContent = data.cart_count;
    });
}

// Call on page load
window.addEventListener("DOMContentLoaded", updateCartIconCount);

document.getElementById("newsletter-form").addEventListener("submit", function(e) {
    e.preventDefault(); // Prevent page reload

    const formData = new FormData(this);

    fetch("newsletter.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        const popup = document.getElementById("subscribe-popup");
        if (data.status === "success") {
            popup.textContent = data.message;
            popup.style.display = "block";
            setTimeout(() => { popup.style.display = "none"; }, 3000);
            this.reset(); // clear input
        } else {
            popup.textContent = data.message;
            popup.style.display = "block";
            setTimeout(() => { popup.style.display = "none"; }, 3000);
        }
    })
    .catch(err => console.error(err));
});



// Open checkout panel
document.getElementById("checkout-btn").addEventListener("click", () => {
    document.getElementById("checkout-panel").style.right = "0";
    document.body.classList.add("checkout-open");
});

// Close checkout panel with X button
document.getElementById("close-checkout").addEventListener("click", () => {
    document.getElementById("checkout-panel").style.right = "-100%";
    document.body.classList.remove("checkout-open");
});

// Handle PAY NOW
document.getElementById("checkout-form").addEventListener("submit", function(e) {
    e.preventDefault();

    // Close checkout panel
    document.getElementById("checkout-panel").style.right = "-100%";
    document.body.classList.remove("checkout-open");

    // Show confirmation popup
    const popup = document.getElementById("payment-popup");
    popup.classList.add("show");

    // Hide popup after 3s
    setTimeout(() => popup.classList.remove("show"), 3000);
});



</script>
<script src="js/main.js"></script>
</body>
</html>

