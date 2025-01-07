<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database configuration
require 'config.php'; // Ensure this file properly sets up $pdo

$error = null;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        // Prepare and execute the query
        $stmt = $pdo->prepare("SELECT doctor_id, password FROM doctors WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user && password_verify($password, $user['password'])) {
            // Store doctor ID in session
            $_SESSION['doctor_id'] = $user['doctor_id'];
            header('Location: dashboard.php'); // Redirect to dashboard
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>౨ৎ⊹₊ ⋆ EHR Login ⊹₊ ⋆౨ৎ</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h2 class="text-center">⊹₊˚‧₊୨Login୧₊‧˚⊹₊</h2>
                            <!--ERROR--> <!-- Error message will appear here -->

                            <form action="login.php" method="POST">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username 𝜗𝜚𓈒ㅤ</label>
                                    <input type="text" id="username" name="username" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password 𝜗𝜚𓈒ㅤ</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </form>
                            <p class="text-center mt-3">
                                <a href="register.php">Don't have an account? <br> Register</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
