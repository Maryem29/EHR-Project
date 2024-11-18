<?php
require 'config.php';
require 'middleware.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ehr_id = $_POST['ehr_id'];
    $medical_history = $_POST['medical_history'];
    $allergies = $_POST['allergies'];
    $medications = $_POST['medications'];

    $stmt = $pdo->prepare("UPDATE ehr_records SET medical_history = ?, allergies = ?, medications = ? WHERE ehr_id = ? AND doctor_id = ?");
    $stmt->execute([$medical_history, $allergies, $medications, $ehr_id, $_SESSION['doctor_id']]);

    echo "EHR record updated successfully!";
}
?>
