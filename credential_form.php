<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credential form</title>
    <link rel="stylesheet" href="credential.css">
</head>
<body>
<div class="container">
        <div class="form-box">
            <h2>Credential Form</h2>
            <form action="profile.php" method="POST">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="age">Age:</label>
                    <input type="number" id="age" name="age" required>
                </div>
                <div class="form-group">
                    <label for="birthday">Birthday (MMDDYY):</label>
                    <input type="text" id="birthday" name="birthday" required pattern="\d{6}">
                </div>
                <div class="form-group">
                    <label for="height">Height (cm):</label>
                    <input type="number" id="height" name="height" required>
                </div>
                <div class="form-group">
                    <label for="weight">Weight (kg):</label>
                    <input type="number" id="weight" name="weight" required>
                </div>
                <div class="form-group">
                    <label for="blood_pressure">Blood Pressure:</label>
                    <input type="text" id="blood_pressure" name="blood_pressure" required>
                </div>
                <div class="form-group">
                    <label for="symptoms">Symptoms:</label>
                    <textarea id="symptoms" name="symptoms" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>