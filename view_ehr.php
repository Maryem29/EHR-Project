<?php
session_start();
require 'config.php';

if (!isset($_SESSION['doctor_id'])) {
    header('Location: login.php');
    exit;
}

$doctor_id = $_SESSION['doctor_id'];
$patient_id = $_GET['patient_id'];

// Ensure the patient belongs to the doctor
$stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ? AND doctor_id = ?");
$stmt->execute([$patient_id, $doctor_id]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    echo "You are not authorized to view or edit this patient.";
    exit;
}

// Fetch the existing EHR record for this patient
$stmt = $pdo->prepare("SELECT * FROM ehr_records WHERE patient_id = ? AND doctor_id = ?");
$stmt->execute([$patient_id, $doctor_id]);
$ehr = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medical_history = $_POST['medical_history'];
    $allergies = $_POST['allergies'];
    $medications = $_POST['medications'];

    // If an EHR record already exists, update it; otherwise, insert a new record
    if ($ehr) {
        // Update existing record
        $stmt = $pdo->prepare("UPDATE ehr_records SET medical_history = ?, allergies = ?, medications = ? WHERE ehr_id = ?");
        $stmt->execute([$medical_history, $allergies, $medications, $ehr['ehr_id']]);
        echo "<p>EHR record updated successfully!</p>";
    } else {
        // Insert new EHR record
        $stmt = $pdo->prepare("INSERT INTO ehr_records (patient_id, doctor_id, medical_history, allergies, medications) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$patient_id, $doctor_id, $medical_history, $allergies, $medications]);
        echo "<p>EHR record added successfully!</p>";
    }
}

// If there's an existing EHR record, display it
if ($ehr) {
    echo "<h3>Current EHR Record for " . htmlspecialchars($patient['name']) . "</h3>";
    echo "<p><strong>Medical History:</strong> " . htmlspecialchars($ehr['medical_history']) . "</p>";
    echo "<p><strong>Allergies:</strong> " . htmlspecialchars($ehr['allergies']) . "</p>";
    echo "<p><strong>Medications:</strong> " . htmlspecialchars($ehr['medications']) . "</p>";
    echo "<a href='view_ehr.php?patient_id=$patient_id'>Refresh EHR Record</a>";
    echo "<br>";
}

?>

<h1>Patient: <?php echo htmlspecialchars($patient['name']); ?></h1>

<h3>Add or Edit EHR Record</h3>

<!-- If no existing record, allow the user to add a new one -->
<form action="view_ehr.php?patient_id=<?php echo $patient_id; ?>" method="POST">
    <label for="medical_history">Medical History:</label>
    <textarea name="medical_history" required><?php echo $ehr['medical_history'] ?? ''; ?></textarea><br>

    <label for="allergies">Allergies:</label>
    <textarea name="allergies"><?php echo $ehr['allergies'] ?? ''; ?></textarea><br>

    <label for="medications">Medications:</label>
    <textarea name="medications"><?php echo $ehr['medications'] ?? ''; ?></textarea><br>

    <button type="submit"><?php echo $ehr ? 'Update' : 'Add'; ?> EHR Record</button>
</form>

<a href="dashboard.php">Go back to Dashboard</a> <!-- Cancel action -->
<a href="view_ehr.php?patient_id=<?php echo $patient_id; ?>">Go back to Patient EHR</a> <!-- Refresh the page -->

