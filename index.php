<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EHR System - Home</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header { background: #007bff; color: white; padding: 1rem; text-align: center; }
        nav { margin: 1rem; text-align: center; }
        nav a { margin: 0 1rem; text-decoration: none; color: #007bff; }
        nav a:hover { text-decoration: underline; }
        main { padding: 1rem; text-align: center; }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to the EHR System</h1>
    </header>
    <main>
        <?php if (!isset($_SESSION['doctor_id'])): ?>
            <!-- Guest View -->
            <h2>About Us</h2>
            <p>
                Our EHR (Electronic Health Records) system is designed to simplify the management of patient data, ensuring security and privacy.
            </p>
            <p>
                With this system, doctors can seamlessly add, update, and manage patient records and associated EHR data.
            </p>
            <nav>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </nav>
        <?php else: ?>
            <!-- Logged-in View -->
            <h2>Welcome, Doctor</h2>
            <p>
                You are logged in. Use the links below to navigate through the system.
            </p>
            <nav>
                <a href="dashboard.php">Manage Patients</a>
                <a href="logout.php">Logout</a>
            </nav>
        <?php endif; ?>
    </main>
</body>
</html>
