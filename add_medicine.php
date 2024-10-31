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

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process form submission if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process the form data
    $brandName = mysqli_real_escape_string($conn, $_POST['brandName']);
    $medicineName = mysqli_real_escape_string($conn, $_POST['medicineName']);
    $quantity = (int)$_POST['quantity'];
    $manufacturedDate = $_POST['manufacturedDate'];
    $expirationDate = $_POST['expirationDate'];

    // SQL statement to insert medicine into the database
    $sql = "INSERT INTO medicine_inventory (brand_name, medicine_name, quantity, manufactured_date, expiration_date) 
        VALUES ('$brandName', '$medicineName', $quantity, '$manufacturedDate', '$expirationDate')";

    if (mysqli_query($conn, $sql)) {
    // Redirect to admin dashboard or display success message
    header('Location: admin_dashboard.php');
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
    <title>Add Medicine</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="add_medicine.css">
</head>
<body>
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
    <div class="container">
        <div class="form-header">
            <h1><i class="fas fa-pills"></i> Add Medicine</h1>
            <p>Please enter the details of the new medicine below.</p>
        </div>

        <!-- Form to add medicine -->
        <form action="" method="post" class="medicine-form">
            <div class="form-group">
                <label for="brandName"><i class="fas fa-prescription-bottle-alt"></i> Brand Name</label>
                <input type="text" id="brandName" name="brandName" placeholder="Enter brand name" required>
            </div>
            <div class="form-group">
                <label for="medicineName"><i class="fas fa-prescription-bottle-alt"></i> Medicine Name</label>
                <input type="text" id="medicineName" name="medicineName" placeholder="Enter medicine name" required>
            </div>
            <div class="form-group">
                <label for="quantity"><i class="fas fa-sort-numeric-up"></i> Quantity</label>
                <input type="number" id="quantity" name="quantity" placeholder="Enter quantity" required>
            </div>
            <div class="form-group">
                <label for="manufacturedDate"><i class="fas fa-calendar-check"></i> Manufactured Date</label>
                <input type="date" id="manufacturedDate" name="manufacturedDate" required>
            </div>
            <div class="form-group">
                <label for="expirationDate"><i class="fas fa-calendar-times"></i> Expiration Date</label>
                <input type="date" id="expirationDate" name="expirationDate" required>
            </div>
            <div class="form-group">
                <button type="submit"><i class="fas fa-plus-circle"></i> Add Medicine</button>
            </div>
        </form>
    </div>
    <div class="back-container">
    <a href="admin_dashboard.php" class="back"><i class="fas fa-arrow-left"></i> Back to Dashboard</a><br><br>
</div>
</div>
</body>
</html>

<?php
// Close database connection
mysqli_close($conn);
?>
