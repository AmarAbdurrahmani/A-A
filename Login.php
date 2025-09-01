<?php
session_start();
include 'config.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0){
        $stmt->bind_result($id, $hashed_password);
        $stmt->fetch();

        if(password_verify($password, $hashed_password)){
            $_SESSION['user_id'] = $id;
            header("Location: shop.html");
            exit;
        } else {
            $message = "Incorrect password!";
        }
    } else {
        $message = "No user found with that email!";
    }
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - A&A</title>
    <link rel="icon" type="image/png" href="img/logo.png">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Petrona&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { font-family: 'Petrona', sans-serif; background: url('img/background.jpg') no-repeat center/cover; color: #fff; margin:0; }
        .content-box {
            position: absolute; top: 60%; left: 50%; transform: translate(-50%, -50%);
            width: 400px; height: 300px; background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2); display: flex; justify-content: center; align-items: center;
            padding: 20px; flex-direction: column;
        }
        .content-box h1 { font-size: 2.5em; margin-bottom: 10px; }
        .content-box p { font-size: 0.9em; color: #ccc; margin-bottom: 20px; }
        input { width: 300px; padding: 12px; margin-bottom: 15px; border:none; border-radius:4px; outline:none; font-size:0.95rem; }
        button { width: 30%; padding: 12px; border:none; border-radius:4px; cursor:pointer; background:#fff; color:#000; font-weight:bold; }
        button:hover { background:#000; color:#fff; }
        .message { margin-bottom:10px; color: yellow; font-weight:bold; text-align:center; }
        .forgot-link { text-align:right; width:90%; margin-bottom:15px; }
        .forgot-link a { color:#fff; text-decoration:none; }
        .forgot-link a:hover{ color:#ccc; }
        .a1{font-family: 'Petrona', sans-serif;}
        .sp{color:#fff;}
        .sp:hover{color:#ccc;}
        .aa{color:#fff;}
        

        /* New CSS for Responsiveness */
@media screen and (max-width: 768px) {
    .content-box {
        /*
        The login box will now take up 80% of the screen's width
        on tablets to give it more room.
        */
        width: 70%;
        height: auto; /* Let the height adjust naturally */
        position: static; /* Remove the fixed positioning */
        transform: none; /* Remove the transform */
        margin: 20px auto; /* Center the box and add some top/bottom margin */
        margin-top: -500px;
    }

    .content-box h1 {
        font-size: 2em; /* Smaller font for h1 on tablets */
    }

    .a1 {
        /*
        This makes all elements with class 'a1' (the inputs and button)
        take up the full width of their container.
        */
        width: 75%;
    }
}

@media screen and (max-width: 480px) {
    .content-box {
        /* On small phones, the login box will take up 95% of the screen */
        width: 75%;
        padding: 15px; /* Adjust padding to be slightly smaller */
    }

    .content-box h1 {
        font-size: 1.8em; /* Even smaller h1 font for phones */
    }

    .content-box p {
        font-size: 0.8em; /* Adjust paragraph font size */
        text-align: center; /* Center the text for better readability */
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
    </main>

    <div class="content-box">
        <h1>Log In</h1>

        <?php if($message) echo "<div class='message'>$message</div>"; ?>

        <form action="login.php" method="post">
            <input class="a1" type="email" name="email" placeholder="Your email address" required>
            <input class="a1" type="password" name="password" placeholder="Your password" required>

            <div class="forgot-link">
                <a href="#">Forgot password?</a>
            </div>

            <button class="a1" type="submit">Log In</button>
        </form><br>
        <p class="signup-text"><a class="aa">New here?</a> <a class="sp"href="signup.php">Sign Up</a></p>
    </div>

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
    </script>
</body>
</html>
