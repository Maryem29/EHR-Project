<!-- view_ehr.php -->
<?php
require 'config.php';
require 'middleware.php';

$doctor_id = $_SESSION['doctor_id'];
$stmt = $pdo->prepare("SELECT * FROM ehr_records WHERE doctor_id = ?");
$stmt->execute([$doctor_id]);
$records = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View EHR Records</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>View EHR Records</h2>
    <?php foreach ($records as $record): ?>
        <p>Medical History: <?= htmlspecialchars($record['medical_history']); ?></p>
        <!-- Display other fields similarly -->
        <hr>
    <?php endforeach; ?>
</body>
</html>
