<?php
require 'config.php';
require 'middleware.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ehr_id = $_POST['ehr_id'];

    $stmt = $pdo->prepare("DELETE FROM ehr_records WHERE ehr_id = ? AND doctor_id = ?");
    $stmt->execute([$ehr_id, $_SESSION['doctor_id']]);

    echo "EHR record deleted successfully!";
}
?>
