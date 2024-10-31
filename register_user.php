<?php
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "multi_login_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$message_type = ""; // To hold the type of message (success or error)

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = md5($_POST['password']);
    $role = $_POST['role'];

    // Check if the username already exists
    $check_stmt = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $check_stmt->bind_param("s", $user);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $message = "Oops! This username is already taken. Please try a different one.";
        $message_type = "error"; // Set message type as error
    } else {
        // Using prepared statements to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user, $pass, $role);

        if ($stmt->execute()) {
            $message = "Congratulations! Your account has been successfully created.";
            $message_type = "success"; // Set message type as success
        } else {
            $message = "Error: " . $stmt->error;
            $message_type = "error"; // Set message type as error
        }

        $stmt->close();
    }

    $check_stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="register_user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome for icons -->
</head>
<body>
    <div class="container">
        <!-- Display messages with icons and improved styling -->
        <div class="message-box <?php echo $message_type; ?>">
            <div class="icon">
                <?php if ($message_type == "success"): ?>
                    <i class="fas fa-check-circle"></i>
                <?php elseif ($message_type == "error"): ?>
                    <i class="fas fa-exclamation-circle"></i>
                <?php endif; ?>
            </div>
            <div class="content">
                <h2><?php echo ($message_type == "success") ? "Success!" : "Error!"; ?></h2>
                <p><?php echo $message; ?></p>
                <?php if ($message_type == "success"): ?>
                    <a href="index.php" class="btn success-btn">Go to Login</a>
                <?php else: ?>
                    <a href="register.php" class="btn error-btn">Try Again</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
