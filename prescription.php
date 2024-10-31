<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'doctor') {
    header('Location: index.php');
    exit();
}

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'multi_login_system';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$patientId = $_GET['id'] ?? null;
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $prescription = $_POST['prescription'];
    $patientId = $_POST['patient_id'];

    $sql = "INSERT INTO prescriptions (patient_id, prescription) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $patientId, $prescription);
    if ($stmt->execute()) {
        $successMessage = "Prescription added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Prescription</title>
    <link rel="stylesheet" href="doctor.css">
</head>
<body>
<div class="navbar">
    <div class="username">
        <?php
        if (isset($_SESSION['username'])) {
            echo htmlspecialchars($_SESSION['username']);
        }
        ?>
    </div>
    <a href="doctor_dashboard.php?logout=true" class="logout">Logout</a>
</div>

<div class="container">
    <div class="form-box">
        <h2>Add Prescription</h2>
        <?php if ($successMessage): ?>
        <p class="success-message"><?php echo htmlspecialchars($successMessage); ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patientId); ?>">
            <div class="form-group">
                <label for="prescription">Prescription:</label>
                <textarea id="prescription" name="prescription" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>

<?php
$conn->close();
?>
