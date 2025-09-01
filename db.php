<?php
$host = "localhost";      // Laragon default
$dbname = "aa_store";     // change if needed
$username = "root";       // Laragon default user
$password = "";           // Laragon default has no password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
