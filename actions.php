<?php
session_start();
include "db.php";

// Temporary logged-in user
$_SESSION['user_id'] = 1;
$user_id = $_SESSION['user_id'];

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;

    // ===== Favorites =====
    if ($action == "toggle_favorite" && $product_id) {
        $stmt = $pdo->prepare("SELECT * FROM favorites WHERE user_id=? AND product_id=?");
        $stmt->execute([$user_id, $product_id]);
        if ($stmt->rowCount() > 0) {
            $pdo->prepare("DELETE FROM favorites WHERE user_id=? AND product_id=?")->execute([$user_id, $product_id]);
            echo json_encode(["status" => "removed"]);
        } else {
            $pdo->prepare("INSERT INTO favorites (user_id, product_id) VALUES (?, ?)")->execute([$user_id, $product_id]);
            echo json_encode(["status" => "added"]);
        }
        exit;
    }

    // ===== Add to Cart (only once) =====
    if ($action == "add_cart" && $product_id) {
        $stmt = $pdo->prepare("SELECT * FROM cart WHERE user_id=? AND product_id=?");
        $stmt->execute([$user_id, $product_id]);
        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "exists"]);
        } else {
            $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity, size) VALUES (?, ?, 1, 'M')")->execute([$user_id, $product_id]);
            $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM cart WHERE user_id=?");
            $countStmt->execute([$user_id]);
            $total = $countStmt->fetch()['total'] ?? 0;
            echo json_encode(["status" => "added", "cart_count" => $total]);
        }
        exit;
    }

    // ===== Get Cart Count =====
    if ($action == "get_cart_count") {
        $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM cart WHERE user_id=?");
        $countStmt->execute([$user_id]);
        $total = $countStmt->fetch()['total'] ?? 0;
        echo json_encode(["cart_count" => $total]);
        exit;
    }

    // ===== Update Quantity =====
    if ($action == "update_quantity" && $product_id) {
        $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
        $stmt = $pdo->prepare("UPDATE cart SET quantity=? WHERE user_id=? AND product_id=?");
        $stmt->execute([$quantity, $user_id, $product_id]);
        echo json_encode(["status" => "success"]);
        exit;
    }

    // ===== Remove from Cart =====
    if ($action == "remove" && $product_id) {  // make sure frontend calls 'remove'
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id=? AND product_id=?");
        $stmt->execute([$user_id, $product_id]);
        echo json_encode(["status" => "success"]);
        exit;
    }

    // ===== Update Size =====
    if ($action == "update_size" && $product_id) {
        $size = isset($_POST['size']) ? $_POST['size'] : '';
        $stmt = $pdo->prepare("UPDATE cart SET size=? WHERE user_id=? AND product_id=?");
        $stmt->execute([$size, $user_id, $product_id]);
        echo json_encode(["status" => "success"]);
        exit;
    }
}
