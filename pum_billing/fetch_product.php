<?php
include 'db_connection.php'; // include the database connection file

// SQL query to fetch data
$sql = "SELECT product_code, product_name, price, stock FROM products"; // Replace 'products' with your table name
$result = $conn->query($sql); // Execute the query

// Check if there are any results
if ($result->num_rows > 0) {
    // Output data for each row
    while($row = $result->fetch_assoc()) {
        echo "Product Code: " . $row["product_code"] . "<br>";
        echo "Product Name: " . $row["product_name"] . "<br>";
        echo "Price: " . $row["price"] . "<br>";
        echo "Stock: " . $row["stock"] . "<br><br>";
    }
} else {
    echo "0 results found";
}

// Close the connection
$conn->close();
?>
