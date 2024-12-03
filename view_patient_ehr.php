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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">EHR System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="text-center">Patient and EHR Record</h2>
        <div class="card shadow mt-4">
            <div class="card-body">
                <h3 class="card-title">Patient Details</h3>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($patient['name']); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($patient['age']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></p>
                <p><strong>Weight:</strong> <?php echo htmlspecialchars($patient['weight']); ?> kg</p>
                <a href="edit_patient.php?patient_id=<?php echo $patient_id; ?>" class="btn btn-primary">Edit Patient Information</a>
            </div>
        </div>
        <div class="card shadow mt-4">
            <div class="card-body">
                <h3 class="card-title">EHR Details</h3>
                <?php if ($ehr): ?>
                    <p><strong>Medical History:</strong> <?php echo htmlspecialchars($ehr['medical_history']); ?></p>
                    <p><strong>Allergies:</strong> <?php echo htmlspecialchars($ehr['allergies']); ?></p>
                    <p><strong>Medications:</strong> <?php echo htmlspecialchars($ehr['medications']); ?></p>
                    <a href="edit_ehr.php?ehr_id=<?php echo $ehr['ehr_id']; ?>&patient_id=<?php echo $patient_id; ?>" class="btn btn-primary">Edit EHR Record</a>
                <?php else: ?>
                    <p>No EHR record found for this patient.</p>
                    <a href="add_ehr.php?patient_id=<?php echo $patient_id; ?>" class="btn btn-success">Add EHR Record</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


