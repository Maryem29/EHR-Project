<!-- login.php -->
<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM doctors WHERE username = ?");
    $stmt->execute([$username]);
    $doctor = $stmt->fetch();

    if ($doctor && password_verify($password, $doctor['password_hash'])) {
        $_SESSION['doctor_id'] = $doctor['doctor_id'];
        echo "<p>Login successful!</p>";
        // Redirect to dashboard or another page
    } else {
        echo "<p>Invalid username or password.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Doctor Login</h2>
    <form method="POST" action="login.php">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
