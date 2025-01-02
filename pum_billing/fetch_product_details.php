<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "khadi");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get product code from the request
$product_code = $_GET['product_code'];

// SQL query to fetch product details from Stock table
$sql = "SELECT price, gst_per FROM Stock WHERE product_code = '$product_code' LIMIT 1";
$result = $conn->query($sql);

// If product found, return details as JSON
if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    echo json_encode($product);
} else {
    echo json_encode(null);  // Return null if product not found
}

// Close the connection
$conn->close();
?>
