<?php
$host = '127.0.0.1'; // Use 127.0.0.1 instead of 'localhost' to force TCP/IP
$dbname = 'ehr_system';
$username = 'root';
$password = ''; // Replace with your MySQL password if set

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "Database connection successful!";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

