<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'multi_login_system';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed']));
}

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);
$medicine_id = (int)$data['id'];
$new_quantity = (int)$data['quantity'];

// Update the quantity in the database
$sql = "UPDATE medicine_inventory SET quantity = $new_quantity WHERE id = $medicine_id";
if (mysqli_query($conn, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update quantity']);
}

mysqli_close($conn);
?>
