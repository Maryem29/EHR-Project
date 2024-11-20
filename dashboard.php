<?php
session_start();
require 'config.php';

if (!isset($_SESSION['doctor_id'])) {
    header('Location: login.php');
    exit;
}

$doctor_id = $_SESSION['doctor_id'];

// Fetch patients associated with the doctor
$stmt = $pdo->prepare("SELECT * FROM patients WHERE doctor_id = ?");
$stmt->execute([$doctor_id]);
$patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<h1>Welcome to your Dashboard</h1>
<a href="add_patient.php">Add New Patient</a>

<h2>Your Patients:</h2>
<table>
    <tr>
        <th>Patient Name</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Weight</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($patients as $patient): ?>
        <tr>
            <td><?php echo htmlspecialchars($patient['name']); ?></td>
            <td><?php echo $patient['age']; ?></td>
            <td><?php echo $patient['gender']; ?></td>
            <td><?php echo $patient['weight']; ?></td>
            <td><a href="view_ehr.php?patient_id=<?php echo $patient['patient_id']; ?>">View EHR</a></td>
        </tr>
    <?php endforeach; ?>
</table>


