<?php
require 'config.php'; // Include the database configuration

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    


    // Validate form input
    if ($password !== $confirm_password) {
        echo "<p>Error: Passwords do not match.</p>";
    } else {
        // Hash the password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert the doctor into the database
        try {
            $stmt = $pdo->prepare("INSERT INTO doctors (username, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $password_hash]);
	    echo "<p>Registration successful! <a href='login.php'>Log in here</a>.</p>";

	    
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry error
                echo "<p>Error: Username or email already exists.</p>";
            } else {
                echo "<p>Error: " . $e->getMessage() . "</p>";
            }
	}

	
    }
    
}


?>



<h2>Doctor Registration</h2>
<form action="register.php" method="POST">
    <label for="username">Username:</label>
    <input type="text" name="username" required><br>
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>
    <label for="password">Password:</label>
    <input type="password" name="password" required><br>
    <label for="confirm_password">Confirm Password:</label>
    <input type="password" name="confirm_password" required><br>
    <button type="submit">Register</button>
</form>
