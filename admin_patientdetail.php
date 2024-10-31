<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php"); 
    exit();
}

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'multi_login_system';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$patient = null;
$prescriptions = [];
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM patients WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $patient = mysqli_fetch_assoc($result);
    }

    $sql = "SELECT * FROM prescriptions WHERE patient_id = $id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $prescriptions[] = $row;
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['prescription'])) {
    $prescription = mysqli_real_escape_string($conn, $_POST['prescription']);
    $sql = "INSERT INTO prescriptions (patient_id, prescription) VALUES ($id, '$prescription')";
    if (mysqli_query($conn, $sql)) {
        // Redirect to avoid form resubmission on refresh
        header("Location: admin_patientdetail.php?id=$id");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="admin_patientdetail.css"> <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="navbar">
    <div class="center-title">
        <img src="logo.png" alt="Logo" class="navbar-logo"> Marie Poussepin Care Center
    </div>
    <div class="right-section">
        <div class="username">
            <i class="fas fa-circle-user username-icon"></i>
            <?php if (isset($_SESSION['username'])) { echo htmlspecialchars($_SESSION['username']); } ?>
        </div>
        <a href="?logout=true" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="container">
    <!-- Left Column: Patient Record -->
    <div class="left-column">
        <?php if ($patient): ?>
        <div class="table-container">
            <h2><i class="fas fa-user"></i> Patient Record</h2>
            <table>
                <tbody>
                    <tr>
                        <th>Name:</th>
                        <td><?php echo htmlspecialchars($patient['name']); ?></td>
                    </tr>
                    <tr>
                        <th>Age:</th>
                        <td><?php echo htmlspecialchars($patient['age']); ?></td>
                    </tr>
                    <tr>
                        <th>Sex:</th>
                        <td><?php echo htmlspecialchars($patient['sex']); ?></td>
                    </tr>
                    <tr>
                        <th>Birthday:</th>
                        <td><?php echo htmlspecialchars($patient['birthday']); ?></td>
                    </tr>
                    <tr>
                        <th>Address:</th>
                        <td><?php echo htmlspecialchars($patient['address']); ?></td>
                    </tr>
                    <tr>
                        <th>Contact No:</th>
                        <td><?php echo htmlspecialchars($patient['contact_no']); ?></td>
                    </tr>
                    <tr>
                        <th>Height (cm):</th>
                        <td><?php echo htmlspecialchars($patient['height']); ?></td>
                    </tr>
                    <tr>
                        <th>Weight (kg):</th>
                        <td><?php echo htmlspecialchars($patient['weight']); ?></td>
                    </tr>
                    <tr>
                        <th>Blood Pressure:</th>
                        <td><?php echo htmlspecialchars($patient['blood_pressure']); ?></td>
                    </tr>
                    <tr>
                        <th>Allergies:</th>
                        <td><?php echo nl2br(htmlspecialchars($patient['allergies'])); ?></td>
                    </tr>
                    <tr>
                        <th>Medical History:</th>
                        <td><?php echo nl2br(htmlspecialchars($patient['medical_history'])); ?></td>
                    </tr>
                    <tr>
                        <th>Symptoms:</th>
                        <td><?php echo nl2br(htmlspecialchars($patient['symptoms'])); ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p>Patient not found.</p>
        <?php endif; ?>
    </div>

    <!-- Right Column: Prescriptions -->
    <div class="right-column">
        <div class="table-container">
            <h2><i class="fas fa-file-prescription"></i> Prescriptions</h2>
            <?php if (count($prescriptions) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Prescription</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prescriptions as $prescription): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($prescription['created_at']); ?></td>
                        <td><?php echo htmlspecialchars($prescription['prescription']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>No prescriptions found.</p>
            <?php endif; ?>
        </div>

        <!-- Add Prescription -->
        <div class="table-container">
        <h2><i class="fas fa-plus"></i> Add Prescription</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="prescription"><i class="fas fa-pencil-alt"></i> Prescription:</label> <br><br><br>
                <textarea id="prescription" name="prescription" rows="4" required></textarea><br><br>
            </div>
            <div class="form-group">
                <button type="submit"><i class="fas fa-plus-circle"></i> Add Prescription</button>
            </div>
        </form>
        </div>
    </div>
</div>

<div class="back-container">
    <a href="admin_patientinfo.php" class="back"><i class="fas fa-arrow-left"></i> Back to Patient Information</a><br><br>
</div>

</body>
</html>