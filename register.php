<?php
session_start();

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Clear the error after displaying it
}

if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Clear the success after displaying it
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="register.css">
    <title>Register</title>
</head>
<body>
    <div class="register-container">
        <h2>Create an Account</h2>
        
        <!-- Success Message -->
        <?php if (isset($success_message)): ?>
            <div class="success-message" id="successMessage">
                <?php echo $success_message; ?>
                <span class="close-btn" onclick="closeSuccessMessage()">&times;</span>
            </div>
        <?php endif; ?>

        <!-- Error Message -->
        <?php if (isset($error_message)): ?>
            <div class="error-message" id="errorMessage">
                <?php echo $error_message; ?>
                <span class="close-btn" onclick="closeErrorMessage()">&times;</span>
            </div>
        <?php endif; ?>

        <form action="register_user.php" method="post">
            <div class="input-container">
                <i class="fas fa-user"></i>
                <input type="text" id="username" name="username" placeholder="Username" required>
            </div>
            <div class="password-container input-container">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility()">
                    <i id="eye-icon" class="fas fa-eye"></i>
                </span>
            </div>
            <div class="input-container">
                <i class="fas fa-user-tag"></i>
                <select id="role" name="role" required>
                    <option value="" disabled selected>Select your role</option>
                    <option value="admin">Admin</option>
                    <option value="doctor">Doctor</option>
                    <option value="patient">Patient</option>
                </select>
            </div>
            <button type="submit" class="register-button">Register</button>
        </form>
        <p>Already have an account? <a href="index.php">Login here</a></p>
    </div>

    <script>
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

        function closeErrorMessage() {
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.style.opacity = '0';
            setTimeout(() => {
                errorMessage.style.display = 'none';
            }, 600);
        }

        function closeSuccessMessage() {
            const successMessage = document.getElementById('successMessage');
            successMessage.style.opacity = '0';
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 600);
        }
    </script>
</body>
</html>
