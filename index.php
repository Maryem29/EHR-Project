<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EHR System - Home</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css"> <!-- Replace with the path to your custom CSS -->
</head>
<body>
    <!-- Header Section -->
    <header class="bg-primary text-white text-center py-4">
        <h1>Welcome to the EHR System</h1>
    </header>

    <!-- Main Section -->
    <main class="container my-5">
        <!-- Guest View -->
        <section class="text-center">
            <h2>About Us</h2>
            <p>
                Our EHR (Electronic Health Records) system is designed to simplify the management of patient data, ensuring security and privacy.
            </p>
            <p>
                With this system, doctors can seamlessly add, update, and manage patient records and associated EHR data.
            </p>
            <nav class="mt-4">
                <a href="login.php" class="btn btn-primary me-2">Login</a>
                <a href="register.php" class="btn btn-secondary">Register</a>
            </nav>
        </section>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

