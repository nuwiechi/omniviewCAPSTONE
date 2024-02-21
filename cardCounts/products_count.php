<?php
	// Include database connection file
	include_once 'db_connection.php';

	// Query to get the total number of suppliers
	$sql = "SELECT COUNT(*) AS total FROM products";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    	$row = $result->fetch_assoc();
    	$totalProducts = $row['total'];
	} else {
    	$totalProducts = 0;
	}

	// Close the database connection
	$conn->close();

	// Return the total number of suppliers
	echo $totalProducts;
?>