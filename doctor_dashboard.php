<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'doctor') {
    header('Location: index.php');
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'multi_login_system';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch total number of patients
$patientResult = mysqli_query($conn, "SELECT COUNT(*) AS total_patients FROM patients");
$patientData = mysqli_fetch_assoc($patientResult);
$totalPatients = $patientData['total_patients'];

// Fetch total number of male patients
$maleResult = mysqli_query($conn, "SELECT COUNT(*) AS male_patients FROM patients WHERE sex = 'Male'");
$maleData = mysqli_fetch_assoc($maleResult);
$malePatients = $maleData['male_patients'];

// Fetch total number of female patients
$femaleResult = mysqli_query($conn, "SELECT COUNT(*) AS female_patients FROM patients WHERE sex = 'Female'");
$femaleData = mysqli_fetch_assoc($femaleResult);
$femalePatients = $femaleData['female_patients'];
$newPatientsResult = mysqli_query($conn, "SELECT name, created_at FROM patients ORDER BY created_at DESC LIMIT 10");
// Fetch total number of medicines
$medicineResult = mysqli_query($conn, "SELECT COUNT(*) AS total_medicines FROM medicine_inventory");
$medicineData = mysqli_fetch_assoc($medicineResult);
$totalMedicines = $medicineData['total_medicines'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="doctor_dashboard.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="center-title">
        <img src="logo.png" alt="Logo" class="navbar-logo">  Marie Poussepin Care Center
    </div>
    <div class="right-section">
        <div class="username">
             <i class="fas fa-circle-user username-icon"></i>
            <?php if (isset($_SESSION['username'])) { echo htmlspecialchars($_SESSION['username']); } ?>
        </div>
        <a href="?logout=true" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
<!-- Main Content Area -->
<div class="main-content">
    <h1><i class="fas fa-chart-pie"></i> Dashboard Overview</h1><br><br><br>
    <div class="analytics">
        <!-- Card for Total Patients -->
        <div class="card total-patients" onclick="window.location='doctor_patientinfo.php'">
            <i class="fas fa-user-injured icon"></i>
            <h3>View Patients</h3>
            <p><?php echo $totalPatients; ?></p>
        </div>

        <div class="card total-medicine" onclick="window.location='doctor_medicine.php'">
                <i class="fas fa-pills icon"></i> <!-- Icon for Total Medicines -->
                <h3>View Medicines</h3>
                <p><?php echo $totalMedicines; ?></p>
            </div>
</div>
       <div class="new-patients-section">
    <h3>Newly Registered Patients</h3>
    <table class="new-patients-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Registration Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($newPatient = mysqli_fetch_assoc($newPatientsResult)): ?>
            <tr>
                <td><?php echo htmlspecialchars($newPatient['name']); ?></td>
                <td><?php echo htmlspecialchars($newPatient['created_at']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>