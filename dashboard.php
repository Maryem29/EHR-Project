<?php
session_start();
require 'config.php';

if (!isset($_SESSION['doctor_id'])) {
    header('Location: login.php');
    exit;
}

$doctor_id = $_SESSION['doctor_id'];

// Fetch patients for the logged-in doctor
$stmt = $pdo->prepare("SELECT * FROM patients WHERE doctor_id = ?");
$stmt->execute([$doctor_id]);
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Welcome to your dashboard! Manage your patients and their EHR records below.</p>
    <nav>
        <a href="index.php">Home</a> |
        <a href="logout.php">Logout</a>
    </nav>
    <h2>Your Patients</h2>
    <a href="add_patient.php">Add New Patient</a>
    <ul>
        <?php foreach ($patients as $patient): ?>
            <li>
                <?php echo htmlspecialchars($patient['name']); ?> 
                (Age: <?php echo $patient['age']; ?>)
                - <a href="view_patient_ehr.php?patient_id=<?php echo $patient['patient_id']; ?>">See More</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>

