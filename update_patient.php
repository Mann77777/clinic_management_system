<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'patient') {
    header('Location: index.php');
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
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle the update process
        $name = $_POST['name'];
        $age = $_POST['age'];
        $sex = $_POST['sex'];
        $birthday = $_POST['birthday'];
        $address = $_POST['address'];
        $contact_no = $_POST['contact_no'];
        $height = $_POST['height'];
        $weight = $_POST['weight'];
        $blood_pressure = $_POST['blood_pressure'];
        $allergies = $_POST['allergies'];
        $medical_history = $_POST['medical_history'];
        $symptoms = $_POST['symptoms'];

        $sql = "UPDATE patients SET 
            name='$name', 
            age='$age', 
            sex='$sex', 
            birthday='$birthday', 
            address='$address', 
            contact_no='$contact_no', 
            height='$height', 
            weight='$weight', 
            blood_pressure='$blood_pressure', 
            allergies='$allergies', 
            medical_history='$medical_history', 
            symptoms='$symptoms'
            WHERE id=$id";

        if (mysqli_query($conn, $sql)) {
            header("Location: admin_patientdetail.php?id=$id&update=success");
            exit();
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }

    $sql = "SELECT * FROM patients WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $patient = mysqli_fetch_assoc($result);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Patient Record</title>
    <link rel="stylesheet" href="admin_patientdetail.css">
</head>
<body>
<div class="container">
    <h2>Update Patient Record</h2>
    <?php if ($patient): ?>
    <form method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($patient['name']); ?>" required>

        <label for="age">Age:</label>
        <input type="number" name="age" value="<?php echo htmlspecialchars($patient['age']); ?>" required>

        <label for="sex">Sex:</label>
        <select name="sex" required>
            <option value="Male" <?php if ($patient['sex'] == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($patient['sex'] == 'Female') echo 'selected'; ?>>Female</option>
        </select>

        <label for="birthday">Birthday:</label>
        <input type="date" name="birthday" value="<?php echo htmlspecialchars($patient['birthday']); ?>" required>

        <label for="address">Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($patient['address']); ?>" required>

        <label for="contact_no">Contact No:</label>
        <input type="text" name="contact_no" value="<?php echo htmlspecialchars($patient['contact_no']); ?>" required>

        <label for="height">Height (cm):</label>
        <input type="number" name="height" value="<?php echo htmlspecialchars($patient['height']); ?>" required>

        <label for="weight">Weight (kg):</label>
        <input type="number" name="weight" value="<?php echo htmlspecialchars($patient['weight']); ?>" required>

        <label for="blood_pressure">Blood Pressure:</label>
        <input type="text" name="blood_pressure" value="<?php echo htmlspecialchars($patient['blood_pressure']); ?>" required>

        <label for="allergies">Allergies:</label>
        <textarea name="allergies" required><?php echo htmlspecialchars($patient['allergies']); ?></textarea>

        <label for="medical_history">Medical History:</label>
        <textarea name="medical_history" required><?php echo htmlspecialchars($patient['medical_history']); ?></textarea>

        <label for="symptoms">Symptoms:</label>
        <textarea name="symptoms" required><?php echo htmlspecialchars($patient['symptoms']); ?></textarea>

        <button type="submit">Update Record</button>
    </form>
    <?php else: ?>
    <p>Patient not found.</p>
    <?php endif; ?>
</div>
</body>
</html>
