<?php
session_start();
include 'login.html';
require 'config.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch the doctor from the database
    $stmt = $pdo->prepare("SELECT doctor_id, password FROM doctors WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['doctor_id'] = $user['doctor_id']; // Store doctor ID in session
        header('Location: dashboard.php'); // Redirect to the dashboard page
        exit;
    } else {
        echo "Invalid username or password.";
    }
}
?>