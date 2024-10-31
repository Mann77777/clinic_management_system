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

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'multi_login_system';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Search and sort functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name'; // Default sorting column
$sort_order = isset($_GET['sort_order']) && $_GET['sort_order'] === 'desc' ? 'desc' : 'asc'; // Default sorting order

$whereClause = '';
if (!empty($search)) {
    $whereClause = " WHERE name LIKE '%$search%'";
}

// Modify SQL query to fetch name, age, sex, birthday, and created_at based on sort column and order
$sql = "SELECT id, name, age, sex, birthday, created_at FROM patients $whereClause ORDER BY $sort_by $sort_order";
$result = mysqli_query($conn, $sql);
$patients = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patients[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="admin_patientinfo.css">
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
    <h2>Patient Information</h2>
    <div class="search">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Search by name" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Patient table with sorting buttons for Name, Age, Sex, Birthday, Created At, and View Button-->
    <table>
    <thead>
    <tr>
        <th>
            <a href="?search=<?php echo htmlspecialchars($search); ?>&sort_by=name&sort_order=<?php echo ($sort_by === 'name' && $sort_order === 'asc') ? 'desc' : 'asc'; ?>">
                Name
                <i class="fas fa-sort-<?php echo ($sort_by === 'name' && $sort_order === 'asc') ? 'up' : 'down'; ?>"></i>
            </a>
        </th>
        <th>
            <a href="?search=<?php echo htmlspecialchars($search); ?>&sort_by=age&sort_order=<?php echo ($sort_by === 'age' && $sort_order === 'asc') ? 'desc' : 'asc'; ?>">
                Age
                <i class="fas fa-sort-<?php echo ($sort_by === 'age' && $sort_order === 'asc') ? 'up' : 'down'; ?>"></i>
            </a>
        </th>
        <th>
            <a href="?search=<?php echo htmlspecialchars($search); ?>&sort_by=sex&sort_order=<?php echo ($sort_by === 'sex' && $sort_order === 'asc') ? 'desc' : 'asc'; ?>">
                Sex
                <i class="fas fa-sort-<?php echo ($sort_by === 'sex' && $sort_order === 'asc') ? 'up' : 'down'; ?>"></i>
            </a>
        </th>
        <th>
            <a href="?search=<?php echo htmlspecialchars($search); ?>&sort_by=birthday&sort_order=<?php echo ($sort_by === 'birthday' && $sort_order === 'asc') ? 'desc' : 'asc'; ?>">
                Birthday
                <i class="fas fa-sort-<?php echo ($sort_by === 'birthday' && $sort_order === 'asc') ? 'up' : 'down'; ?>"></i>
            </a>
        </th>
        <th>
            <a href="?search=<?php echo htmlspecialchars($search); ?>&sort_by=created_at&sort_order=<?php echo ($sort_by === 'created_at' && $sort_order === 'asc') ? 'desc' : 'asc'; ?>">
                Created At
                <i class="fas fa-sort-<?php echo ($sort_by === 'created_at' && $sort_order === 'asc') ? 'up' : 'down'; ?>"></i>
            </a>
        </th>
        <!-- Add new "Action" column header -->
        <th>Action</th>
    </tr>
</thead>
<tbody>
    <?php if (count($patients) > 0): ?>
        <?php foreach ($patients as $patient): ?>
        <tr>
            <td><?php echo htmlspecialchars($patient['name']); ?></td>
            <td><?php echo htmlspecialchars($patient['age']); ?></td>
            <td><?php echo htmlspecialchars($patient['sex']); ?></td>
            <td><?php echo htmlspecialchars($patient['birthday']); ?></td>
            <td><?php echo htmlspecialchars($patient['created_at']); ?></td>
            <!-- "View" button in the "Action" column -->
            <td class="view-container">
                <a href="admin_patientdetail.php?id=<?php echo htmlspecialchars($patient['id']); ?>" class="view-button">View</a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No patients found.</td>
        </tr>
    <?php endif; ?>
</tbody>


    </table>
</div>

<div class="back-container">
    <a href="admin_dashboard.php" class="back"><i class="fas fa-arrow-left"></i> Back to Dashboard</a><br><br>
</div>
</body>
</html>

<?php
mysqli_close($conn);
?>
