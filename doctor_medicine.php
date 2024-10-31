<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'doctor') {
    header('Location: index.php');
    exit();
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php"); 
    exit();
}

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'multi_login_system';

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize search and sort variables
$search = "";
$order_by = "medicine_name"; // Default order by medicine name
$order_type = "ASC"; // Default order type

// Check if search form is submitted
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
}

// Check if sort parameters are set
if (isset($_GET['sort'])) {
    $order_by = mysqli_real_escape_string($conn, $_GET['sort']);
}

if (isset($_GET['order'])) {
    $order_type = mysqli_real_escape_string($conn, $_GET['order']);
}

// SQL query to fetch medicines with search and sorting
$sql = "SELECT * FROM medicine_inventory 
        WHERE medicine_name LIKE '%$search%' 
        ORDER BY $order_by $order_type";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Medicine Inventory</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="doctor_dashboard.css">
    <style>
/* Additional styles for the table to match patient information structure */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    border-radius: 8px;
    overflow: hidden;
    background-color: #ebf7f6; /* White background for the table */
}
table th, table td {
    padding: 12px 15px;
    text-align: center; /* Center align text */
    color: #003135; /* Text color for table content */
}
table th {
    background-color: #b2d8ea; /* Header background color (blue) */
    color: #31708e; /* White text for header */
    font-weight: bold;
    font-size: 16px;
    text-transform: uppercase;
}
table td {
    border-bottom: 1px solid #ddd;
    color: #003135; /* Text color for table content */
}
table tr:hover {
    background-color: #b2d8ea; /* Light blue hover effect */
}
.search-container {
    text-align: right;
    margin-bottom: 20px;
}
.search-container input[type="text"] {
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 4px;
    width: 250px;
}
.search-container button {
    padding: 8px 12px;
    font-size: 16px;
    background-color: #024950;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left: 5px;
}
.search-container button:hover {
    background-color: #023737;
}
.sort-icon {
    margin-left: 5px;
    font-size: 12px; /* Smaller icon size */
}
.quantity-controls {
    display: flex;
    align-items: center;
    justify-content: center; /* Center the content horizontally */
}
.quantity-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 20px;
    padding: 0 10px;
}
input[type="number"] {
    width: 60px;
    text-align: center; /* Center the text in the input field */
    border: 1px solid #ddd;
    border-radius: 4px;


}
</style>
</head>
<body>

<!-- Navbar -->
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
    <!-- Main Content Area -->
    <div class="main-content">
        <h1><i class="fas fa-archive"></i> Medicine Inventory</h1>
        <div class="search-container">
            <form method="post">
                <input type="text" name="search" placeholder="Search Medicine..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit"><i class="fas fa-search"></i> Search</button>
            </form>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>
                        <a href="?sort=brand_name&order=<?php echo ($order_type === 'ASC' ? 'DESC' : 'ASC'); ?>">Brand Name</a>
                        <i class="fas fa-sort<?php echo ($order_by === 'brand_name') ? ($order_type === 'ASC' ? '-up' : '-down') : ''; ?>" aria-hidden="true" class="sort-icon"></i>
                    </th>
                    <th>
                        <a href="?sort=medicine_name&order=<?php echo ($order_type === 'ASC' ? 'DESC' : 'ASC'); ?>">Medicine Name</a>
                        <i class="fas fa-sort<?php echo ($order_by === 'medicine_name') ? ($order_type === 'ASC' ? '-up' : '-down') : ''; ?>" aria-hidden="true" class="sort-icon"></i>
                    </th>
                    <th>
                        <a href="?sort=quantity&order=<?php echo ($order_type === 'ASC' ? 'DESC' : 'ASC'); ?>">Quantity</a>
                        <i class="fas fa-sort<?php echo ($order_by === 'quantity') ? ($order_type === 'ASC' ? '-up' : '-down') : ''; ?>" aria-hidden="true" class="sort-icon"></i>
                    </th>
                    <th>
                        <a href="?sort=manufactured_date&order=<?php echo ($order_type === 'ASC' ? 'DESC' : 'ASC'); ?>">Manufactured Date</a>
                        <i class="fas fa-sort<?php echo ($order_by === 'manufactured_date') ? ($order_type === 'ASC' ? '-up' : '-down') : ''; ?>" aria-hidden="true" class="sort-icon"></i>
                    </th>
                    <th>
                        <a href="?sort=expiration_date&order=<?php echo ($order_type === 'ASC' ? 'DESC' : 'ASC'); ?>">Expiration Date</a>
                        <i class="fas fa-sort<?php echo ($order_by === 'expiration_date') ? ($order_type === 'ASC' ? '-up' : '-down') : ''; ?>" aria-hidden="true" class="sort-icon"></i>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $medicine_id = htmlspecialchars($row['id']); // Assuming you have an ID column
                        $quantity = htmlspecialchars($row['quantity']);
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['brand_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['medicine_name']) . "</td>";
                        echo "<td>
                                <div class='quantity-controls'>
                                    <button class='quantity-btn' onclick='updateQuantity($medicine_id, -1)'><i class='fas fa-chevron-down'></i></button>
                                    <input type='number' id='quantity_$medicine_id' value='$quantity' min='0' readonly>
                                    <button class='quantity-btn' onclick='updateQuantity($medicine_id, 1)'><i class='fas fa-chevron-up'></i></button>
                                </div>
                              </td>";
                        echo "<td>" . htmlspecialchars($row['manufactured_date']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['expiration_date']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No medicine data available</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="back-container">
        <a href="doctor_dashboard.php" class="back"><i class="fas fa-arrow-left"></i> Back to Dashboard</a><br><br>
    </div>
<script>
function updateQuantity(medicineId, change) {
    const quantityInput = document.getElementById(`quantity_${medicineId}`);
    let currentQuantity = parseInt(quantityInput.value);
    const newQuantity = currentQuantity + change;

    if (newQuantity < 0) return; // Prevent going below zero

    quantityInput.value = newQuantity;

    // Send the updated quantity to the server
    fetch('update_quantity.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: medicineId,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Quantity updated successfully.');
        } else {
            console.error('Error updating quantity:', data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

</body>
</html>

<?php
mysqli_close($conn);
?>
