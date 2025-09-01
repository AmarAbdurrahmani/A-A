<?php
include 'config.php';
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $hashed_password);

    if ($stmt->execute()) {
        $message = "Signup successful! <a href='login.php'>Login here</a>";
    } else {
        $message = "Error: " . $stmt->error;
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
    <title>Sign Up - A&A</title>
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
        .a1{font-family: 'Petrona', sans-serif;}
        .aa{color: #fff;}
        .lg{color:#fff;}
        .lg:hover{color:#ccc;}
        @media(max-width:768px){ .content-box{width:90%;} input{width:100%;} h1{font-size:2em;} }
    </style>
</head>
<body>
    
    <!-- Header -->
    <header class="navbar">
        <div class="logo">A&A</div>
        <nav class="nav-links">
            <ul>
                <li><a href="index.html">HOME</a></li>
                <li><a href="shop.html">SHOP</a></li>
                <li><a href="#">HOODIES</a></li>
                <li><a href="#">T-SHIRTS</a></li>
                <li><a href="#">ACCESSORIES</a></li>
                <li><a href="#">JACKETS</a></li>
            </ul>
        </nav>
        <div class="nav-icons">
            <a href="Login.php"><i class="fa-regular fa-user"></i></a>
            <!--<a href="favorites.html"><i class="fa-regular fa-heart"></i></a>
            <a href="cart.html"><i class="fa-solid fa-cart-shopping outline-icon"></i></a>-->
        </div>
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
        <h1>Sign Up</h1>

        <?php if($message) echo "<div class='message'>$message</div>"; ?>

        <form action="signup.php" method="post">
            <input class="a1" type="email" name="email" placeholder="Your email address" required>
            <input class="a1" type="password" name="password" placeholder="Your password" required>
            <button class="a1" type="submit">Sign Up</button>
        </form><br>
        <p class="signup-text"><a class="aa">Already have an account?</a> <a class="lg" href="login.php">Log In</a></p>
    </div>
</body>
</html>
