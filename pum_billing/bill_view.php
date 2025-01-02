<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "khadi");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all bills grouped by invoice_number
$sql = "SELECT * FROM bills ORDER BY invoice_number DESC";
$result = $conn->query($sql);

// Initialize a structure to store grouped data
$grouped_bills = [];
while ($row = $result->fetch_assoc()) {
    $grouped_bills[$row['invoice_number']][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill View</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .print-button {
            background-color: #007BFF;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        .print-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="topnav">
<a href="../index.php">Home</a> 
  <a href="billing.php">Billing</a>
  <a class="active"  href="bill_view.php">Bill View</a>
  <a href="stock.php">Stock Inward</a>
  <a href="stock_view.php">Stock View</a>
  <a href="#">Stock Outward</a>
</div>
    <h1>Bill View</h1>

    <?php if (isset($_GET['message'])): ?>
        <p class="success"><?= htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <?php if (!empty($grouped_bills)): ?>
        <table>
            <thead>
                <tr>
                    <th>Invoice Number</th>
                    <th>Customer Mobile</th>
                    <th>Total Items</th>
                    <th>Net Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($grouped_bills as $invoice_number => $bills): ?>
                    <tr>
                        <td><?= $invoice_number; ?></td>
                        <td><?= $bills[0]['customer_mobile']; ?></td>
                        <td><?= count($bills); ?></td>
                        <td>
                            <?= array_sum(array_column($bills, 'net_amount')); ?>
                        </td>
                        <td>
                            <a href="bill_print.php?invoice_number=<?= $invoice_number; ?>" class="print-button">View & Print</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No bills found.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</body>
</html>
