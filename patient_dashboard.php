<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'patient') {
    header('Location: index.php');
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
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

// Function to fetch patient details
function getPatientDetails($conn, $username) {
    $sql = "SELECT * FROM patients WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();
    $stmt->close();
    return $patient;
}

// Function to fetch prescriptions
function getPrescriptions($conn, $patientId) {
    $sql = "SELECT * FROM prescriptions WHERE patient_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patientId);
    $stmt->execute();
    $result = $stmt->get_result();
    $prescriptions = [];
    while ($row = $result->fetch_assoc()) {
        $prescriptions[] = $row;
    }
    $stmt->close();
    return $prescriptions;
}

// Initialize variables
$patient = null;
$successMessage = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle patient details submission
    $name = $_POST['name'];
    $age = (int)$_POST['age'];
    $sex = isset($_POST['sex']) ? $_POST['sex'] : '';
    $birthday = $_POST['birthday'];
    $address = $_POST['address'];
    $contact_no = $_POST['contact_no'];
    $height = (int)$_POST['height'];
    $weight = (int)$_POST['weight'];
    $blood_pressure = $_POST['blood_pressure'];
     // Process medical history: store as a comma-separated list
     $medical_history = isset($_POST['medical_history']) ? implode(', ', $_POST['medical_history']) : '';
    
     // Process allergies: Checkbox value
     $allergies = isset($_POST['allergies']) ? implode(', ', $_POST['allergies']) : '';
     
     $symptoms = $_POST['symptoms'];
 
     // Save form data into the database
     $sql = "INSERT INTO patients (username, name, age, sex, birthday, address, contact_no, height, weight, blood_pressure, allergies, medical_history, symptoms) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
     $stmt = $conn->prepare($sql);
     $stmt->bind_param("ssssssssissss", $_SESSION['username'], $name, $age, $sex, $birthday, $address, $contact_no, $height, $weight, $blood_pressure, $allergies, $medical_history, $symptoms);
     
     if ($stmt->execute()) {
         echo "Record saved successfully!";
     } else {
         echo "Error: " . $stmt->error;
     }
     $stmt->close();
 
    // Reload patient data
    $patient = getPatientDetails($conn, $_SESSION['username']);
}

// Fetch patient details based on username if not reloaded
if (!$patient) {
    $patient = getPatientDetails($conn, $_SESSION['username']);
}

// Fetch prescriptions if patient details are available
$prescriptions = [];
if ($patient && isset($patient['id'])) {
    $prescriptions = getPrescriptions($conn, $patient['id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="patient.css">
</head>
<body>
<div class="navbar">
    <div class="center-title">
        <img src="logo.png" alt="Logo" class="navbar-logo">  Marie Poussepin Care Center
    </div>
    <div class="right-section">
        <div class="username">
             <i class="fas fa-username-icon"></i>
            <?php if (isset($_SESSION['username'])) { echo htmlspecialchars($_SESSION['username']); } ?>
        </div>
        <a href="?logout=true" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<div class="container mt-5">
    <?php if ($patient): ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-user"></i> Patient Record</h4>
                </div>
                <div class="card-body">
                    <?php if ($successMessage): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($successMessage); ?>
                    </div>
                    <?php endif; ?>
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($patient['name']); ?></li>
                        <li class="list-group-item"><strong>Age:</strong> <?php echo htmlspecialchars($patient['age']); ?></li>
                        <li class="list-group-item"><strong>Sex:</strong> <?php echo nl2br(htmlspecialchars($patient['sex'])); ?></li>
                        <li class="list-group-item"><strong>Birthday:</strong> <?php echo htmlspecialchars($patient['birthday']); ?></li>
                        <li class="list-group-item"><strong>Address:</strong> <?php echo htmlspecialchars($patient['address']); ?></li>
                        <li class="list-group-item"><strong>Contact No:</strong> <?php echo htmlspecialchars($patient['contact_no']); ?></li>
                        <li class="list-group-item"><strong>Height (cm):</strong> <?php echo htmlspecialchars($patient['height']); ?></li>
                        <li class="list-group-item"><strong>Weight (kg):</strong> <?php echo htmlspecialchars($patient['weight']); ?></li>
                        <li class="list-group-item"><strong>Blood Pressure:</strong> <?php echo htmlspecialchars($patient['blood_pressure']); ?></li>
                        <li class="list-group-item"><strong>Allergies:</strong> <?php echo nl2br(htmlspecialchars($patient['allergies'])); ?></li>
                        <li class="list-group-item"><strong>Medical History:</strong> <?php echo nl2br(htmlspecialchars($patient['medical_history'])); ?></li>
                        <li class="list-group-item"><strong>Symptoms:</strong> <?php echo nl2br(htmlspecialchars($patient['symptoms'])); ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h4><i class="fas fa-prescription-bottle-alt"></i> Prescriptions</h4>
                </div>
                <div class="card-body">
                    <?php if (count($prescriptions) > 0): ?>
                    <ul class="list-group">
                        <?php foreach ($prescriptions as $prescription): ?>
                        <li class="list-group-item"><?php echo htmlspecialchars($prescription['prescription']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php else: ?>
                    <p>No prescriptions found.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
        <div class="card">
    <div class="card-header bg-info text-white">
        <h4><i class="fas fa-info-circle"></i> Patient Credential Form</h4>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="form-group">
                <label for="name"><i class="fas fa-user"></i> <strong>Name:</strong></label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="sex"><i class="fas fa-venus-mars"></i> <strong>Sex:</strong></label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sex" id="male" value="Male" required>
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="sex" id="female" value="Female" required>
                    <label class="form-check-label" for="female">Female</label>
                </div>
            </div>
            <div class="form-group">
                <label for="birthday"><i class="fas fa-calendar-alt"></i> <strong> Birthday:</strong></label>
                <input type="date" class="form-control" id="birthday" name="birthday" required>
            </div>

            <!-- Age input (read-only) -->
            <div class="form-group">
                <label for="age"><i class="fas fa-sort-numeric-up-alt"></i><strong> Age:</strong> </label>
                <input type="number" class="form-control" id="age" name="age" readonly>
            </div>
            <div class="form-group">
                <label for="address"><i class="fas fa-home"></i> <strong> Address:</strong></label>
                <input type="text" id="address" name="address" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="contact_no"><i class="fas fa-phone"></i><strong> Contact No:</strong> </label>
                <input type="number" id="contact_no" name="contact_no" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="height"><i class="fas fa-ruler-vertical"></i><strong> Height (cm):</strong></label>
                <input type="number" id="height" name="height" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="weight"><i class="fas fa-weight"></i><strong> Weight (kg):</strong></label>
                <input type="number" id="weight" name="weight" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="blood_pressure"><i class="fas fa-heartbeat"></i> <strong> Blood Pressure (e.g., 40-120):</strong></label>
                <input type="text" id="blood_pressure" name="blood_pressure" class="form-control" required pattern="\d{1,3}-\d{1,3}">
                <small class="form-text text-muted">Format: systolic-diastolic (e.g., 120-80).</small>
                  <!-- Medical History Section -->
            <div class="form-group">
                <label for="medical_history"><i class="fas fa-notes-medical"></i> <strong> Past Medical History:</strong></label><br>
                <label><input type="checkbox" name="medical_history[]" value="Asthma"> Asthma</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Bronchitis"> Bronchitis</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Pneumonia"> Pneumonia</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Tuberculosis"> Tuberculosis</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Hypertension"> Hypertension (High Blood Pressure)</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Heart Attack"> Heart Attack</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Stroke"> Stroke</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Diabetes"> Diabetes</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Thyroid Disease"> Thyroid Disease</label><br>
                <label><input type="checkbox" name="medical_history[]" value="High Cholesterol"> High Cholesterol</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Kidney Disease"> Kidney Disease</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Liver Disease"> Liver Disease</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Hepatitis"> Hepatitis</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Gallbladder Disease"> Gallbladder Disease</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Ulcers"> Ulcers</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Gastritis"> Gastritis</label><br>
                <label><input type="checkbox" name="medical_history[]" value="GERD"> GERD (Acid Reflux)</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Irritable Bowel Syndrome"> Irritable Bowel Syndrome (IBS)</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Anemia"> Anemia</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Osteoporosis"> Osteoporosis</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Arthritis"> Arthritis</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Gout"> Gout</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Back Problems"> Back Problems</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Seizures"> Seizures (Epilepsy)</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Migraines"> Migraines</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Depression"> Depression</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Anxiety"> Anxiety</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Bipolar Disorder"> Bipolar Disorder</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Schizophrenia"> Schizophrenia</label><br>
                <label><input type="checkbox" name="medical_history[]" value="Cancer"> Cancer</label><br>
                <input type="checkbox" name="medicalHistory[]" value="None"> None<br>
                <input type="checkbox" name="medicalHistory[]" value="Other"> Other (please specify)<br>
                <input type="text" placeholder="Please specify other medical condition" name="medical_history[]">
            </div>

              <!-- Allergies Section with Checkboxes -->
              <div class="form-group">
                    <label for="allergies"><i class="fas fa-allergies"></i> <strong> Allergies:</strong></label><br>
                    <label><input type="checkbox" name="allergies[]" value="Peanuts"> Peanuts</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Tree Nuts"> Tree Nuts</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Milk"> Milk</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Eggs"> Eggs</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Shellfish"> Shellfish</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Fish"> Fish</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Wheat (Gluten)"> Wheat (Gluten)</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Soy"> Soy</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Penicillin"> Penicillin</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Latex"> Latex</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Insect Stings"> Insect Stings (Bees, Wasps)</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Mold"> Mold</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Pollen"> Pollen</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Dust Mites"> Dust Mites</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Animal Dander"> Animal Dander (Cats, Dogs)</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Fragrances/Perfumes"> Fragrances/Perfumes</label><br>
                    <label><input type="checkbox" name="allergies[]" value="Certain Medications"> Certain Medications</label><br>
                    <label><input type="checkbox" name="allergies[]" value="None"> None</label><br>
                    <input type="checkbox" name="allergies[]" value="Other"> Other (please specify)<br>
                    <input type="text" placeholder="Please specify other allergy" name="allergies[]">
                </div>
                    <div class="form-group">
                        <label for="symptoms"><i class="fas fa-notes-medical"></i><strong> Symptoms:</strong> </label>
                        <textarea id="symptoms" name="symptoms" class="form-control" rows="2" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-save"></i> Submit</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    document.getElementById('birthday').addEventListener('change', function () {
        var today = new Date();
        var birthDate = new Date(this.value);
        var age = today.getFullYear() - birthDate.getFullYear();
        var monthDiff = today.getMonth() - birthDate.getMonth();

        // Adjust age if birthday hasn't occurred this year
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }

        document.getElementById('age').value = age;
    });
    const allergyCheckboxes = document.getElementsByName('allergies[]');
        for (let checkbox of allergyCheckboxes) {
            checkbox.addEventListener('change', function() {
                const otherInput = checkbox.parentElement.querySelector('input[type="text"]');
                if (checkbox.value === 'Other') {
                    otherInput.style.display = checkbox.checked ? 'block' : 'none';
                    otherInput.required = checkbox.checked; // Make required if checked
                    if (!checkbox.checked) {
                        otherInput.value = ''; // Clear input when hidden
                    }
                }
            });
        }

        // Function to show/hide "Other" input for medical history
        const medicalHistoryCheckboxes = document.getElementsByName('medicalHistory[]');
        for (let checkbox of medicalHistoryCheckboxes) {
            checkbox.addEventListener('change', function() {
                const otherInput = checkbox.parentElement.querySelector('input[type="text"]');
                if (checkbox.value === 'Other') {
                    otherInput.style.display = checkbox.checked ? 'block' : 'none';
                    otherInput.required = checkbox.checked; // Make required if checked
                    if (!checkbox.checked) {
                        otherInput.value = ''; // Clear input when hidden
                    }
                }
            });
        }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>