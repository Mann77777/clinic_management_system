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

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'multi_login_system';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch total number of patients (for analytics)
$patientResult = mysqli_query($conn, "SELECT COUNT(*) AS total_patients FROM patients");
$patientData = mysqli_fetch_assoc($patientResult);
$totalPatients = $patientData['total_patients'];

// Fetch total number of medicines (for analytics)
$medicineResult = mysqli_query($conn, "SELECT COUNT(*) AS total_medicines FROM medicine_inventory");
$medicineData = mysqli_fetch_assoc($medicineResult);
$totalMedicines = $medicineData['total_medicines'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="admin_dashboard.css">
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

<!-- Sidebar and Main Dashboard Content -->
<div class="dashboard-container">
<div class="sidebar">
    <div class="user-info">
        <i class="fas fa-circle-user"></i>
        <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <p class="quote">"Everything must aim to the care of the sick and the weak, it is Jesus Christ who is served in the person."</p>
    </div>

    <!-- Container for each choice -->
    <div class="sidebar-choice-container">
        <a href="admin_dashboard.php">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
    </div>
    <div class="sidebar-choice-container">
        <a href="add_medicine.php">
            <i class="fas fa-pills"></i> Add Medicine
        </a>
    </div>
    <div class="sidebar-choice-container">
        <a href="admin_patientinfo.php">
            <i class="fas fa-user-injured"></i> Patient Information
        </a>
    </div>
    <div class="sidebar-choice-container">
        <a href="admin_medicine.php">
            <i class="fas fa-archive"></i> Medicine Inventory
        </a>
    </div>
</div>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1><i class="fas fa-chart-pie"></i> Dashboard Overview</h1><br><br><br>
        <div class="analytics">
            <div class="card" onclick="window.location='admin_patientinfo.php'">
                <i class="fas fa-user-injured icon"></i> <!-- Icon for Total Patients -->
                <h3>Total Patients</h3>
                <p><?php echo $totalPatients; ?></p>
            </div>
            <div class="card" onclick="window.location='admin_medicine.php'">
                <i class="fas fa-pills icon"></i> <!-- Icon for Total Medicines -->
                <h3>Total Medicines</h3>
                <p><?php echo $totalMedicines; ?></p>
            </div>
            <div class="card">
                <i class="fas fa-check-circle icon"></i> <!-- Icon for System Status -->
                <h3>System Status</h3>
                <p>Active</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php
mysqli_close($conn);
?>
