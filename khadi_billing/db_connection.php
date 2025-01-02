<?php
// Get the product code from the request
$product_code = isset($_REQUEST['product_code']) ? $_REQUEST['product_code'] : '';

// Database connection
$con = mysqli_connect("localhost", "root", "", "khadi");

// Check for connection errors
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure product_code is provided
if ($product_code !== "") {
    // Use prepared statements to prevent SQL injection
    $stmt = $con->prepare("SELECT price, gst_per FROM product_master WHERE product_code = ?");
    $stmt->bind_param("s", $product_code);
    $stmt->execute();
    $stmt->bind_result($price, $gst_per);

    // Fetch the data
    if ($stmt->fetch()) {
        // Store the result in an array
        $result = array($price, $gst_per);
    } else {
        // Return an empty result if no product found
        $result = array("error" => "No product found");
    }
    $stmt->close();
} else {
    $result = array("error" => "Invalid product code");
}

// Encode the result as JSON
echo json_encode($result);

// Close the database connection
mysqli_close($con);
?>
