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

$error_message = "";

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
            $error_message = "Invalid role!";
        }
    } else {
        $error_message = "Invalid username or password!";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Font for Navbar Brand -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- External CSS -->
    <link rel="stylesheet" href="style.css">
    <title>Marie Poussepin Care Center - Login</title>
</head>
<body>
    <nav>
        <ul class="main-nav">
            <li class="navbar-brand">
                <a href="#"><img src="logo.png" alt="Logo" class="navbar-logo"> <span class="brand-name">Marie Poussepin Care Center</span></a>
            </li>
            <li class="hideOnMobile"><a href="#">Home</a></li>
            <li class="hideOnMobile"><a href="services.php">Services</a></li>
            <li class="hideOnMobile"><a href="about.php">About</a></li>
            <li class="hideOnMobile"><a href="contactus.php">Contact Us</a></li>
            <li onclick="showSidebar()" class="showOnMobile"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#000000"><path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/></svg></a></li>
        </ul>
    </nav>

    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Menu</h2>
            <span class="sidebar-close" onclick="hideSidebar()">&times;</span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="index.php">Home</a></li>
            <li><a href="services.php">Services</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contactus.php">Contact Us</a></li>
        </ul>
    </div>

    <div class="login-container">
        <h2>Login</h2><br>
        <?php if ($error_message): ?>
            <div class="error-message" id="errorMessage">
                <?php echo $error_message; ?>
                <span class="close-btn" onclick="closeErrorMessage()">&times;</span>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <label for="username">Username</label>
            <div class="input-container">
                <i class="fas fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>

            <label for="password">Password</label>
            <div class="password-container input-container">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility()">
                    <i id="eye-icon" class="fas fa-eye"></i>
                </span>
            </div>

            <button type="submit" class="login-button">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <script>
        function showSidebar(){
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.display = 'flex';
        }
        function hideSidebar(){
            const sidebar = document.querySelector('.sidebar');
            sidebar.style.display = 'none';
        }
        function closeErrorMessage(){
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.style.opacity = '0';
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 600);
        }
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }

        window.addEventListener('resize', function() {
            if (window.innerWidth > 800) {
                hideSidebar();
            }
        });
    </script>
</body>
</html>
