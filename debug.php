<?php
echo "Starting registration process"; // Debug statement
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "Processing form data"; // Debug statement

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO doctors (username, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);

    echo "Registration successful!";
}
?>
