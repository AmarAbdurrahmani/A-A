<?php
session_start();
include "db.php";

// Simulate login user
$_SESSION['user_id'] = 1;
$user_id = $_SESSION['user_id'];

// Get all favorite products
$stmt = $pdo->prepare("SELECT p.* FROM favorites f 
                       JOIN products p ON f.product_id = p.id 
                       WHERE f.user_id = ?");
$stmt->execute([$user_id]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Favorites - A&A</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Petrona&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* ===== Global ===== */
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
        .nav-links ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            gap: 20px;
            position: absolute; /* position it over navbar */
            left: 31%;          /* move left edge to center */
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
                        url("../img/background.jpg") no-repeat center center;
            background-size: cover;
            background-position: center 5%; /* Pushes image down */
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

        /* Hide hamburger menu on desktop by default */
        .hamburger,
        .close-menu {
            display: none;
            cursor: pointer;
        }

        /* ===== Main Sections ===== */
        .hero {
            position: relative;
            height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: linear-gradient(to right, rgba(26, 26, 26, 0.7), rgba(0, 0, 0, 0.7)), url("img/background.jpg") no-repeat center center;
            background-size: cover;
            background-position: center 5%;
        }

        .favorites-title {
            font-family: 'Abhaya Libre', serif;
            position: absolute;
            top: 120px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 2.5rem;
            font-weight: bold;
            color: #fff;
            text-align: center;
            z-index: 10;
        }

        /* Product grid */
        .products-grid {
            font-family: 'Abhaya Libre', serif;
            display: grid;
            /* Changed to 4 columns on desktop for better responsive contrast */
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            margin-top: -500px; /* Adjust this value to overlap the hero section as needed */
            position: relative;
            z-index: 10;
        }

        .product {
            background: #fff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            text-align: center;
            color: #000;
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
        
        /* Added styling for the 'No favorites' message */
        .no-favorites {
            grid-column: 1 / -1; /* Make this element span all columns */
            text-align: center;
            color: #fff;
            font-size: 1.2rem;
            padding: 40px 0;
        }

        .product-icons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 10px;
        }

        .product-icons i {
            font-size: 1.5em;
            cursor: pointer;
            transition: color 0.3s;
        }

        .favorite.red {
            color: red;
        }

        .cart {
            color: #000;
        }

        .popup-inline {
            display: none;
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: black;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        .newsletter {
            background: linear-gradient(rgba(17, 17, 17, 0.8), rgba(17, 17, 17, 0.8)),
                url('img/image.png') center/cover no-repeat;
            color: #fff;
            padding: 150px 10%;
            position: relative;
            z-index: 2; /* ensures it stays above the hero/shop bg */
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
            background: linear-gradient(rgba(17, 17, 17, 0.8), rgba(17, 17, 17, 0.8)),
                url('img/background.jpg') center/cover no-repeat;
            background-size: cover;
            overflow: hidden; /* ensures bg-text stays inside */
            background-position: center 3%; /* Pushes image down */
        }

        .footer .background-text {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            opacity: 0.05; /* fainter in footer */
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

        /* ==================================== */
        /* ========== RESPONSIVE STYLES ======= */
        /* ==================================== */

        /* For Tablets and Mobile devices (up to 992px) */
@media (max-width: 992px) {
    .navbar {
        padding: 15px 20px;
    }

    /* FIX: Show hamburger on tablets and mobile */
    .hamburger {
        display: block;
        font-size: 24px;
        z-index: 1001;
    }

    /* Hide desktop navigation links */
    .nav-links ul,
    .nav-links .nav-icons {
        display: none;
    }

    /* Style the slide-out menu container */
    .nav-links {
        position: fixed;
        top: 0;
        right: -100%;
        width: 70%;
        max-width: 280px;
        height: 100vh;
        background: #fff;
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
        transition: right 0.4s ease-in-out;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 20px;
    }

    /* When menu is active (slid out) */
    .nav-links.active {
        right: 0;
    }
    
    .nav-links.active .close-menu {
        display: block;
        align-self: flex-end;
        color: #000;
        font-size: 28px;
    }

    .nav-links.active ul {
        display: flex;
        flex-direction: column;
        width: 100%;
        margin-top: 20px;
    }

    .nav-links.active ul li {
        margin: 15px 0;
    }

    .nav-links.active ul a {
        color: #000;
        font-size: 1.1em;
    }

    .nav-links.active ul a::after {
        background-color: #000;
    }

    .nav-links.active .nav-icons {
    display: flex;
    margin-top: 400px; /* This creates a fixed space */
    padding-top: 20px;
    border-top: 1px solid #eee;
    width: 100%;
    justify-content: flex-start;
}

    .nav-links.active .nav-icons a {
        color: #000;
        font-size: 1.5em;
        margin-left: 0;
        margin-right: 30px;
    }

    .nav-links.active #cart-count {
        color: #fff;
        background: #000;
    }

    .products-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    /* --- NEW RULE FOR NEWSLETTER --- */
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
}
        
        /* Specific adjustments for smaller mobile screens if needed */
        @media (max-width: 480px) {
            .products-grid {
                /* You could change to 1 column on very small screens if you want */
                /* grid-template-columns: 1fr; */
            }
            .newsletter-form {
                display: flex;
                flex-direction: column;
                width: 100%;
            }
            .newsletter-form input, .newsletter-form button {
                width: 100%;
            }
            .footer-bottom {
                gap: 10px;
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


    <!-- Hero -->
    <main class="hero">
        <div class="background-text">
            <span class="bg-text">A&A</span>
            <span class="bg-text">A&A</span>
            <span class="bg-text">A&A</span>
            <span class="bg-text">A&A</span>
            <span class="bg-text">A&A</span>
        </div>
        <h1 class="favorites-title">My Favorites</h1>
    </main>

    
     <!-- Products -->
    <div class="products-grid">
        <?php if ($favorites): ?>
            <?php foreach ($favorites as $product): ?>
                <div class="product" data-id="<?= $product['id'] ?>">
                    <img src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <h3><?= $product['name'] ?></h3>
                    <p>$<?= $product['price'] ?></p>

                    <div class="product-icons">
                        <i class="fa-solid fa-heart favorite red" title="Remove from favorites"></i>
                        <i class="fa-solid fa-cart-shopping cart" title="Add to cart"></i>
                        <div class="popup-inline">This product is already in your cart!</div>
                    </div>
                </div>
            <?php endforeach; ?><br>
            <br>
        <?php else: ?>
            <p style="color:#fff;">No favorites yet.</p>
        <?php endif; ?>
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


    document.querySelectorAll(".product").forEach(product => {
        const favoriteBtn = product.querySelector(".favorite");
        const cartBtn = product.querySelector(".cart");
        const popup = product.querySelector(".popup-inline");
        const productId = product.dataset.id;

         // Favorite toggle
        favoriteBtn.addEventListener("click", function() {
            fetch("actions.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "action=toggle_favorite&product_id=" + productId
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === "removed") {
                    // Remove the product element instantly
                    product.remove();
                }
            });
        });
        // Add to cart
        cartBtn.addEventListener("click", function() {
            fetch("actions.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "action=add_cart&product_id=" + productId
            })
            .then(res => res.json())
            .then(data => {
                if(data.status === "added") {
                    cartBtn.style.color = "green";
                } else if (data.status === "exists") {
                    popup.style.display = "block";
                    setTimeout(() => popup.style.display = "none", 1500);
                }
            });
        });
    });

    window.addEventListener("DOMContentLoaded", () => {
    const cartCountEl = document.getElementById("cart-count");

    fetch("actions.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "action=get_cart_count"
    })
    .then(res => res.json())
    .then(data => {
        cartCountEl.textContent = data.cart_count ?? 0;
    });
});
    </script>

    <script src="js/main.js"></script>
</body>
</html>
