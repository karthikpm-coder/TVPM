<?php
// Database connection
$conn = mysqli_connect("localhost", "root", "", "khadi");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve invoice number
$invoice_number = $_GET['invoice_number'] ?? '';

if (empty($invoice_number)) {
    echo "Invalid invoice number.";
    exit;
}

// Fetch all bills for the given invoice number
$sql = "SELECT * FROM bills WHERE invoice_number = '$invoice_number' ORDER BY invoice_number ASC"; // Order by invoice_number
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "No bills found for this invoice.";
    exit;
}

$bills = [];
while ($row = $result->fetch_assoc()) {
    $bills[] = $row;
}

// Initialize totals
$total_amount = 0;
$total_taxable_value = 0;
$total_cgst = 0;
$total_sgst = 0;
$total_net_amount = 0;
$current_date_time = date('d-m-Y H:i');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?= $invoice_number; ?></title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f4f4f4;
        }
        .totals-row {
            font-weight: bold;
            background-color: #f4f4f4;
        } 
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
</head>
<body>

<table> 
    <tr>
<td><h3>Invoice Number: KH-<?= $invoice_number; ?></h3></td>
   <td> <h3>Customer Mobile: <?= $bills[0]['customer_mobile']; ?></h3></td>
    <td><h3>Date and Time: <?= $current_date_time; ?></h3></td>
    </tr>
    </table>   
    <table>
        <thead>
            <tr>
                <th>Product Code</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>GST (%)</th>
                <th>Discount (%)</th>
                <th>Total</th>
                <th>Taxable Value</th>
                <th>CGST</th>
                <th>SGST</th>
                <th>Net Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bills as $bill): ?>
                <?php
                // Add current row values to totals
                $total_amount += $bill['total'];
                $total_taxable_value += $bill['taxable_value'];
                $total_cgst += $bill['cgst'];
                $total_sgst += $bill['sgst'];
                $total_net_amount += $bill['net_amount'];
                ?>
                <tr>
                    <td><?= $bill['product_code']; ?></td>
                    <td><?= $bill['qty']; ?></td>
                    <td><?= $bill['price']; ?></td>
                    <td><?= $bill['gst_percentage']; ?></td>
                    <td><?= $bill['discount_percentage']; ?></td>
                    <td><?= $bill['total']; ?></td>
                    <td><?= $bill['taxable_value']; ?></td>
                    <td><?= $bill['cgst']; ?></td>
                    <td><?= $bill['sgst']; ?></td>
                    <td><?= $bill['net_amount']; ?></td>
                </tr>
            <?php endforeach; ?>
            <!-- Display Totals -->
            <tr class="totals-row">
                <td colspan="5" style="text-align: right;">Grand Total</td>
                <td><?= number_format($total_amount, 2); ?></td>
                <td><?= number_format($total_taxable_value, 2); ?></td>
                <td><?= number_format($total_cgst, 2); ?></td>
                <td><?= number_format($total_sgst, 2); ?></td>
                <td><?= number_format($total_net_amount, 2); ?></td>
            </tr>
        </tbody>
    </table>
    <button onclick="window.print()">Print</button>
    <a href="bill_view.php">Back to Bill View</a>
</body>
</html>
