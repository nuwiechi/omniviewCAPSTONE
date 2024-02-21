<?php
include_once 'db_connection.php'; // Adjust the path as needed

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the total number of customers
$sql = "SELECT COUNT(*) AS total_customers FROM customer";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo '' . $row['total_customers'];
} else {
    echo '<p class="card-text">No customers found.</p>';
}

?>
