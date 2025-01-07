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









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">EHR System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="../login.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="../register.php">Register</a></li>
            </ul>
        </div>
    </div>
</nav>


    <!-- Registration Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center">Register</h2>
                        <form action="register.php" method="POST" class="mt-4">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password:</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                        <p class="text-center mt-3">Already have an account? <a href="login.php">Log in here</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

