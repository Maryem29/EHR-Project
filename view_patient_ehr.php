<?php
session_start();
require 'config.php';

if (!isset($_SESSION['doctor_id'])) {
    header('Location: login.php');
    exit;
}

$doctor_id = $_SESSION['doctor_id'];
$patient_id = $_GET['patient_id'];

// Fetch patient details
$stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id = ? AND doctor_id = ?");
$stmt->execute([$patient_id, $doctor_id]);
$patient = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$patient) {
    echo "You are not authorized to view this patient.";
    exit;
}

// Fetch the EHR record for this patient
$stmt = $pdo->prepare("SELECT * FROM ehr_records WHERE patient_id = ? AND doctor_id = ?");
$stmt->execute([$patient_id, $doctor_id]);
$ehr = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient and EHR</title>
</head>
<body>
    <h1>Patient and EHR Record</h1>
    <nav>
        <a href="dashboard.php">Back to Dashboard</a>
    </nav>
    <h2>Patient Details</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($patient['name']); ?></p>
    <p><strong>Age:</strong> <?php echo htmlspecialchars($patient['age']); ?></p>
    <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></p>
    <p><strong>Weight:</strong> <?php echo htmlspecialchars($patient['weight']); ?> kg</p>
    <a href="edit_patient.php?patient_id=<?php echo $patient_id; ?>">Edit Patient Information</a>

    <h2>EHR Details</h2>
    <?php if ($ehr): ?>
        <p><strong>Medical History:</strong> <?php echo htmlspecialchars($ehr['medical_history']); ?></p>
        <p><strong>Allergies:</strong> <?php echo htmlspecialchars($ehr['allergies']); ?></p>
        <p><strong>Medications:</strong> <?php echo htmlspecialchars($ehr['medications']); ?></p>
        <a href="edit_ehr.php?ehr_id=<?php echo $ehr['ehr_id']; ?>&patient_id=<?php echo $patient_id; ?>">Edit EHR Record</a>
    <?php else: ?>
        <p>No EHR record found for this patient.</p>
        <a href="add_ehr.php?patient_id=<?php echo $patient_id; ?>">Add EHR Record</a>
    <?php endif; ?>
</body>
</html>

