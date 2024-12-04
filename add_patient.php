<?php
session_start();
require 'config.php';

if (!isset($_SESSION['doctor_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = $_SESSION['doctor_id'];
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $weight = $_POST['weight'];

    // Insert patient record
    $stmt = $pdo->prepare("INSERT INTO patients (doctor_id, name, age, gender, weight) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$doctor_id, $name, $age, $gender, $weight]);

    echo "<p>Patient added successfully!</p>";
    echo "<a href='dashboard.php'>Go back to Dashboard</a>"; // Link to go back to the dashboard
}
?>

<h2>Add New Patient</h2>
<form action="add_patient.php" method="POST">
    <label for="name">Name:</label><input type="text" name="name" required><br>
    <label for="age">Age:</label><input type="number" name="age" required><br>
    <label for="gender">Gender:</label>
    <select name="gender" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
    </select><br>
    <label for="weight">Weight:</label><input type="number" name="weight" step="0.1"><br>
    <button type="submit">Add Patient</button>
</form>
<a href="dashboard.php">Cancel and go back to Dashboard</a> <!-- Cancel action -->
