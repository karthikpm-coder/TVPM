<?php
// Database connection
$con = mysqli_connect("localhost", "root", "", "khadi");

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form data is received via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $product_code = $_POST['product_code'] ?? '';
    $qty = intval($_POST['qty'] ?? 0);
    $price = floatval($_POST['price'] ?? 0);
    $gst = floatval($_POST['gst'] ?? 0);
    $discount = intval($_POST['discount'] ?? 0);
   

    // Insert data into the database
    $sql = "INSERT INTO invoice (product_code, price, qty, discount, gst)
            VALUES ('$product_code', $price, $qty, $discount, $gst)";

    if (mysqli_query($con, $sql)) {
        echo "Bill successfully saved.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }
}

// Close connection
mysqli_close($con);
?>
