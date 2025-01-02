<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "khadi");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert stock data if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $g_from = $_POST['g_from'];
    $product_code = $_POST['product_code'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $gst_per = $_POST['gst_per'];
    ;

    // SQL query to insert stock into the database
    $sql = "INSERT INTO Stock (g_from, product_code, qty, price, gst_per) 
            VALUES ('$g_from', '$product_code', '$qty', '$price', '$gst_per')";

    if ($conn->query($sql) === TRUE) {
        echo "New stock record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
<style>
body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

.topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: green;
  color: black;
}

.topnav a.active {
  background-color: green;
  color: white;
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Stock</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
    <div class="topnav">
    <a href="../index.php">Home</a>
  <a  href="billing.php">Billing</a>
  <a href="bill_view.php">Bill View</a>
  <a class="active" href="stock.php">Stock Inward</a>
  <a href="stock_view.php">Stock View</a>
  <a href="#">Stock Outward</a>
</div>

        <h1>Add New Stock</h1>
        <form method="POST" action="">
            <label for="g_from">Goods From:</label><br>
            <input type="text" id="g_from" name="g_from" required><br><br>

            <label for="product_code">Product Code:</label><br>
            <input type="text" id="product_code" name="product_code" required><br><br>

            <label for="qty">Quantity:</label><br>
            <input type="number" id="qty" name="qty" required><br><br>

            <label for="price">Unit Price:</label><br>
            <input type="number" step="0.01" id="price" name="price" required><br><br>

            <label for="gst_per">GST (%):</label><br>
            <input type="number" step="0.01" id="gst_per" name="gst_per" required><br><br>


            <input type="submit" value="Add Stock" >
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
