<?php
session_start();
require 'config.php';

if (!isset($_SESSION['doctor_id'])) {
    header('Location: login.php');
    exit;
}

$doctor_id = $_SESSION['doctor_id'];
$patient_id = $_GET['patient_id'];

// Check if the patient exists and belongs to the logged-in doctor
$stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ? AND doctor_id = ?");
$stmt->execute([$patient_id, $doctor_id]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    echo "You are not authorized to add EHR for this patient.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $medical_history = $_POST['medical_history'];
    $allergies = $_POST['allergies'];
    $medications = $_POST['medications'];

    try {
        // Insert the EHR record
        $stmt = $pdo->prepare("INSERT INTO ehr_records (patient_id, doctor_id, medical_history, allergies, medications) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$patient_id, $doctor_id, $medical_history, $allergies, $medications]);

        // Redirect back to view_patient_ehr.php
        header("Location: view_patient_ehr.php?patient_id=$patient_id");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add EHR Record</title>
</head>
<body>
    <h1>Add EHR Record for <?php echo htmlspecialchars($patient['name']); ?></h1>
    <nav>
        <a href="view_patient_ehr.php?patient_id=<?php echo $patient_id; ?>">Back to Patient Details</a>
    </nav>
    <form method="POST">
        <label for="medical_history">Medical History:</label><br>
        <textarea name="medical_history" required></textarea><br>

        <label for="allergies">Allergies:</label><br>
        <textarea name="allergies" required></textarea><br>

        <label for="medications">Medications:</label><br>
        <textarea name="medications" required></textarea><br>

        <button type="submit">Add EHR Record</button>
    </form>
</body>
</html>
