<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $age = htmlspecialchars($_POST['age']);
    $birthday = htmlspecialchars($_POST['birthday']);
    $height = htmlspecialchars($_POST['height']);
    $weight = htmlspecialchars($_POST['weight']);
    $blood_pressure = htmlspecialchars($_POST['blood_pressure']);
    $symptoms = htmlspecialchars($_POST['symptoms']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Profile</title>
    <link rel="stylesheet" href="profile.css">
</head>
<div class="container">
        <div class="profile-box">
            <h2>Patient Profile</h2>
            <div class="profile-group">
                <label>Name:</label>
                <p><?php echo $name; ?></p>
            </div>
            <div class="profile-group">
                <label>Age:</label>
                <p><?php echo $age; ?></p>
            </div>
            <div class="profile-group">
                <label>Birthday:</label>
                <p><?php echo $birthday; ?></p>
            </div>
            <div class="profile-group">
                <label>Height (cm):</label>
                <p><?php echo $height; ?></p>
            </div>
            <div class="profile-group">
                <label>Weight (kg):</label>
                <p><?php echo $weight; ?></p>
            </div>
            <div class="profile-group">
                <label>Blood Pressure:</label>
                <p><?php echo $blood_pressure; ?></p>
            </div>
            <div class="profile-group">
                <label>Symptoms:</label>
                <p><?php echo nl2br($symptoms); ?></p>
            </div>
        </div>
    </div>
</body>
</html>
<?php
} else {
    echo "Invalid request method.";
}
?>
<body>