<?php
require 'config.php';
require 'middleware.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['doctor_id'])) {
        echo "<p>Unauthorized access. Please log in as a doctor.</p>";
        exit;
    }

    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo "<p>Invalid CSRF token.</p>";
        exit;
    }
    unset($_SESSION['csrf_token']);

    $patient_id = htmlspecialchars($_POST['patient_id'], ENT_QUOTES, 'UTF-8');
    $medical_history = htmlspecialchars($_POST['medical_history'], ENT_QUOTES, 'UTF-8');
    $allergies = htmlspecialchars($_POST['allergies'], ENT_QUOTES, 'UTF-8');
    $medications = htmlspecialchars($_POST['medications'], ENT_QUOTES, 'UTF-8');
    $doctor_id = $_SESSION['doctor_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO ehr_records (patient_id, doctor_id, medical_history, allergies, medications) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$patient_id, $doctor_id, $medical_history, $allergies, $medications]);
        echo "<p>EHR record created successfully!</p>";
    } catch (PDOException $e) {
        echo "<p>Failed to create EHR record: " . $e->getMessage() . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create EHR Record</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Create EHR Record</h2>
    <form method="POST" action="create_ehr.php">
        <input type="hidden" name="csrf_token" value="<?php echo bin2hex(random_bytes(32)); ?>">
        <label>Patient ID:</label>
        <input type="number" name="patient_id" required><br>

        <label>Medical History:</label>
        <textarea name="medical_history" required></textarea><br>

        <label>Allergies:</label>
        <input type="text" name="allergies" required><br>

        <label>Medications:</label>
        <input type="text" name="medications" required><br>

        <input type="submit" value="Add Record">
    </form>
</body>
</html>

