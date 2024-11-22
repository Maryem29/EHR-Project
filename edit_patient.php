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
    echo "You are not authorized to edit this patient.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $weight = $_POST['weight'];

    // Update patient information
    $stmt = $pdo->prepare("UPDATE patients SET name = ?, age = ?, gender = ?, weight = ? WHERE patient_id = ? AND doctor_id = ?");
    $stmt->execute([$name, $age, $gender, $weight, $patient_id, $doctor_id]);

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
    <title>Edit Patient</title>
</head>
<body>
    <h1>Edit Patient Information</h1>
    <nav>
        <a href="view_patient_ehr.php?patient_id=<?php echo $patient_id; ?>">Back to Patient Details</a>
    </nav>
    <form method="POST">
        <label for="name">Name:</label><br>
        <input type="text" name="name" value="<?php echo htmlspecialchars($patient['name']); ?>" required><br>

        <label for="age">Age:</label><br>
        <input type="number" name="age" value="<?php echo htmlspecialchars($patient['age']); ?>" required><br>

        <label for="gender">Gender:</label><br>
        <select name="gender" required>
            <option value="Male" <?php if ($patient['gender'] === 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($patient['gender'] === 'Female') echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if ($patient['gender'] === 'Other') echo 'selected'; ?>>Other</option>
        </select><br>

        <label for="weight">Weight (kg):</label><br>
        <input type="number" step="0.1" name="weight" value="<?php echo htmlspecialchars($patient['weight']); ?>"><br>

        <button type="submit">Save Changes</button>
    </form>
</body>
</html>

