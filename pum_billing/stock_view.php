<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "khadi");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch stock data
$sql = "SELECT * FROM Stock";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock View</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styling for the Stock View table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #4CAF50;
            color: white;
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
</head>

<body>
    <div class="container">
        <div class="topnav">
        <a href="../index.php">Home</a>
            <a href="billing.php">Billing</a>
            <a class="active" href="bill_view.php">Bill View</a>
            <a href="stock.php">Stock Inward</a>
            <a href="#">Stock Outward</a>
        </div>

        <h1>Stock View</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Goods From</th>
                        <th>Product Code</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>GST (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['g_from']) . "</td>
                                <td>" . htmlspecialchars($row['product_code']) . "</td>
                                <td>" . htmlspecialchars($row['qty']) . "</td>
                                <td>" . htmlspecialchars($row['price']) . "</td>
                                <td>" . htmlspecialchars($row['gst_per']) . "</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No stock records found.</p>
        <?php endif; ?>

    </div>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>

</html>