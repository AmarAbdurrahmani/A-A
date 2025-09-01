<?php
if (isset($_POST['email'])) {
    $email = trim($_POST['email']);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $file = fopen("newsletter.txt", "a");
        if ($file) {
            fwrite($file, $email . PHP_EOL);
            fclose($file);
            echo json_encode(["status" => "success", "message" => "You subscribed!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Could not save your email."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid email address!"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No email submitted!"]);
}
?>
