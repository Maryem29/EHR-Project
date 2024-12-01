<?php
session_start();
require 'config.php';

if (!isset($_SESSION['doctor_id'])) {
    header('Location: login.php');
    exit;
}

$doctor_id = $_SESSION['doctor_id'];
$ehr_id = $_GET['ehr_id'];
$patient_id = $_GET['patient_id'];

// Fetch the EHR record
$stmt = $pdo->prepare("SELECT * FROM ehr_records WHERE ehr_id = ? AND doctor_id = ?");
$stmt->execute([$ehr_id, $doctor_id]);
$ehr = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ehr) {
    echo "You are not authorized to edit this EHR record.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $medical_history = $_POST['medical_history'];
    $allergies = $_POST['allergies'];
    $medications = $_POST['medications'];

    // Update the EHR record
    $stmt = $pdo->prepare("UPDATE ehr_records SET medical_history = ?, allergies = ?, medications = ? WHERE ehr_id = ?");
    $stmt->execute([$medical_history, $allergies, $medications, $ehr_id]);

    // Redirect back to view_patient_ehr.php
    header("Location: view_patient_ehr.php?patient_id=$patient_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit EHR Record</title>
</head>
<body>
    <h1>Edit EHR Record</h1>
    <form method="POST">
        <label for="medical_history">Medical History:</label><br>
        <textarea name="medical_history" required><?php echo htmlspecialchars($ehr['medical_history']); ?></textarea><br>

        <label for="allergies">Allergies:</label><br>
        <textarea name="allergies"><?php echo htmlspecialchars($ehr['allergies']); ?></textarea><br>

        <label for="medications">Medications:</label><br>
        <textarea name="medications"><?php echo htmlspecialchars($ehr['medications']); ?></textarea><br>

        <button type="submit">Save Changes</button>
    </form>
    <a href="view_patient_ehr.php?patient_id=<?php echo $patient_id; ?>">Cancel</a>
</body>
</html>

