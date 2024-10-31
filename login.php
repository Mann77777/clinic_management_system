<?php
session_start();

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "multi_login_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $user;
        $_SESSION['role'] = $row['role'];

        if ($row['role'] == 'admin') {
            header('Location: admin_dashboard.php');
        } elseif ($row['role'] == 'doctor') {
            header('Location: doctor_dashboard.php');
        } elseif ($row['role'] == 'patient') {
            header('Location: patient_dashboard.php');
        } else {
            echo "Invalid role!";
        }
    } else {
        echo "Invalid username or password!";
    }

    $stmt->close();
}

$conn->close();
?>
