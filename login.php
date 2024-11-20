<?php
session_start();
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


<form action="login.php" method="POST">
	<p>Don't have an account? <a href="register.php">Register here</a>.</p>
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>
    <label for="password">Password:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>



